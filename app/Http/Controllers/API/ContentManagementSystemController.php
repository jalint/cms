<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Client;
use App\Models\CompanyPolicy;
use App\Models\CompanyProfile;
use App\Models\CustomerDistribution;
use App\Models\CustomerDistributionData;
use App\Models\CustomerDistributionLegend;
use App\Models\Directory;
use App\Models\DirectoryDetail;
use App\Models\HomepageService;
use App\Models\LegalDocument;
use App\Models\LegalDocumentDetail;
use App\Models\Milestone;
use App\Models\News;
use App\Models\OrganizationalStructure;
use App\Models\Parameter;
use App\Models\Sector;
use App\Models\Service;
use App\Models\ServiceCard;
use App\Models\ServiceCategory;
use App\Models\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ContentManagementSystemController extends Controller
{
    public function index()
    {
        $Home_Banner = 1;

        $Struktur_Organisasi_Banner = 3;
        $Legalitas_Banner = 4;
        $Jenis_Layanan_Banner = 5;
        $Direktori_Banner = 6;
        $Karir_Banner = 7;

        $Footer_Banner = 9;
        $Tentang_Perusahaan_Photo = 10;
        $Logo_Sertifikasi = 11;

        $media = DB::table('media')
            ->join('categories', 'media.category_id', '=', 'categories.id')
            ->select('media.id', 'path', 'categories.name as type')
            ->whereIn('category_id', [
                $Home_Banner,
                $Logo_Sertifikasi,
                $Footer_Banner,
            ])
            ->get();

        $highlightNews = DB::table('news')
            ->select([
                'id',
                'title_id',
                'title_en',
                'content_id',
                'content_en',
                'created_at',
            ])
            ->where('is_highlight', 1)
            ->get();

        $testimonials = DB::table('homepage_testimonials')
            ->select([
                'id',
                'photo',
                'customer_logo',
                'name',
                'description_id',
                'description_en',
            ])
            ->get();

        $services = HomepageService::query()
            ->with([
                'homepagecards' => function ($query) {
                    $query->where('is_active', 1);
                },
            ])
            ->get();

        $randomNews = DB::table('news')
            ->select(['id', 'title_id', 'title_en', 'created_at'])
            ->where('is_highlight', 1)
            ->inRandomOrder()
            ->get();

        return response()->json([
            'media' => $media,
            'highlight_news' => $highlightNews,
            'testimonials' => $testimonials,
            'random_news' => $randomNews,
            'services' => $services,
            'random_news' => $randomNews,
        ]);
    }

    public function homepageServices()
    {
        $Logo_Klien = 12;

        $services = HomepageService::query()
            ->with([
                'homepagecards' => function ($query) {
                    $query->where('is_active', 1);
                },
            ])
            ->whereIn('position', [1, 2, 3, 4])
            ->get();

        $media = DB::table('media')
            ->join('categories', 'media.category_id', '=', 'categories.id')
            ->select('media.id', 'path', 'categories.name as type')
            ->where('category_id', $Logo_Klien)
            ->get();

        // Sisipkan media ke dalam data dengan position = 4
        $services = $services->map(function ($item) use ($media) {
            if ($item->position == 4) {
                $item->images = $media;
            }

            return $item;
        });

        return response()->json($services);
    }

    // highlight,popular,random,latest
    public function news(Request $request)
    {
        $filter = $request->input('filter');
        $q = $request->input('q');
        $perPage = $request->input('per_page', 15);

        // latest: ambil 4 berita terbaru saja
        if ($filter === 'latest') {
            $news = News::query()
                ->latest()
                ->limit(4)
                ->get();

            return response()->json($news);
        }

        // filter lain tetap seperti semula
        $news = News::query()
            ->when($filter === 'highlight', fn ($query) => $query->where('is_highlight', 1))
            ->when($filter === 'popular', fn ($query) => $query->orderByDesc('view_count')->limit(5))
            ->when($filter === 'random', fn ($query) => $query->inRandomOrder())
            ->when($q, fn ($query) => $query->where('title_id', 'like', "%{$q}%"))
            ->paginate($perPage);

        return response()->json($news);
    }

    public function newsDetails(Request $request)
    {
        $data = DB::table('news')
            ->where('slug_id', $request->slug)
            ->orWhere('slug_en', $request->slug)
            ->first();

        if ($data) {
            DB::table('news')
                ->where('id', $data->id)
                ->increment('view_count');
        }

        return response()->json($data);
    }

    public function contactUs()
    {
        $FOOTER_BANNER_CATEGORY_ID = 9;
        $FOOTER_POSITION = 7;

        $media = Cache::remember(
            "media.footer_banner.{$FOOTER_BANNER_CATEGORY_ID}",
            300,
            function () use ($FOOTER_BANNER_CATEGORY_ID) {
                return DB::table('media')
                    ->select('path')
                    ->where('category_id', $FOOTER_BANNER_CATEGORY_ID)
                    ->orderByDesc('id') // pastikan ambil yang terbaru kalau lebih dari satu
                    ->first();
            },
        );

        $service = Cache::remember(
            "homepage_service.footer.{$FOOTER_POSITION}",
            300,
            function () use ($FOOTER_POSITION) {
                return DB::table('homepage_services')
                    ->select('badge_id', 'badge_en', 'title_id', 'title_en')
                    ->where('position', $FOOTER_POSITION)
                    ->first();
            },
        );

        if (!$media || !$service) {
            return response()->json(
                [
                    'message' => 'Footer media atau service tidak ditemukan.',
                ],
                Response::HTTP_NOT_FOUND,
            );
        }

        return response()->json([
            'image' => $media->path
                ? env('APP_URL').Storage::url($media->path)
                : null,
            'badge_id' => $service->badge_id,
            'badge_en' => $service->badge_en,
            'title_id' => $service->title_id,
            'title_en' => $service->title_en,
        ]);
    }

    public function testimonials()
    {
        $TESTIMONIAL_POSITION = 5;

        $testimonailService = DB::table('homepage_services')
            ->select(
                'badge_id',
                'badge_en',
                'title_id',
                'title_en',
                'description_id',
                'description_en',
            )
            ->where('position', $TESTIMONIAL_POSITION)
            ->first();

        $testimonials = DB::table('homepage_testimonials')
            ->select([
                'id',
                'photo',
                'customer_logo',
                'name',
                'description_id',
                'description_en',
                'job_title',
            ])
            ->where('is_active', 1)
            ->get();

        $testimonailService->testimonials = [$testimonials];

        return response()->json($testimonailService);
    }

    public function latestNews()
    {
        $LATEST_NEWS = 6;
        $Logo_Sertifikasi = 11;

        $latestNews = DB::table('homepage_services')
            ->select(
                'badge_id',
                'badge_en',
                'title_id',
                'title_en',
                'description_id',
                'description_en',
            )
            ->where('position', $LATEST_NEWS)
            ->first();

        $logoSertifikasi = DB::table('media')
            ->join('categories', 'media.category_id', '=', 'categories.id')
            ->select('media.id', 'path', 'categories.name as type')
            ->where('category_id', $Logo_Sertifikasi)
            ->get();

        $latestNews->logo_setifikasi = $logoSertifikasi ?? null;

        return response()->json($latestNews);
    }

    /**
     * Company Profil.
     */
    public function companyProfiles()
    {
        // Ambil profil perusahaan pertama (atau sesuaikan dengan kebutuhan)
        $companyProfile = CompanyProfile::first();

        $profile_perusahaan_banner = 2;

        // Ambil banner yang sesuai
        $banner = DB::table('media')
            ->select('id', 'path')
            ->where('category_id', $profile_perusahaan_banner)
            ->first();

        // Tambahkan atribut baru secara dinamis
        $companyProfile->image = $banner->path;

        return response()->json($companyProfile);
    }

    public function milestones()
    {
        $milestones = Milestone::query()
         ->with(['milestoneDetails' => function ($query) {
             $query->orderBy('year', 'desc');
         }])
         ->first();

        return response()->json($milestones);
    }

    public function parameterCharts()
    {
        $parameters = Parameter::query()->with('parameterValues')->first();

        return response()->json($parameters);
    }

    public function customerDistributions()
    {
        $customerDistributions = CustomerDistribution::query()->first();

        $customerDistributions->map_legend = CustomerDistributionLegend::query()
            ->select(['id', 'hex', 'legenda'])
            ->get();

        return response()->json($customerDistributions);
    }

    public function customerDistributionData()
    {
        $data = CustomerDistributionData::query()
            ->with('customerDistributionLegend')
            ->get();

        return response()->json($data);
    }

    public function organizationStructures()
    {
        $data = OrganizationalStructure::query()->first();
        $Struktur_Organisasi_Banner = 3;

        $strukturBanner = DB::table('media')
            ->select('media.id', 'path')
            ->where('category_id', $Struktur_Organisasi_Banner)
            ->first();

        $data->image = $strukturBanner->path ?? null;

        return response()->json($data);
    }

    public function companyPolicies()
    {
        $data = CompanyPolicy::query()->with('companyPolicyDetails')->first();

        return response()->json($data);
    }

    public function legalDocumentCategory(Request $request)
    {
        $data = LegalDocument::query()->select(['id', 'title_id', 'title_en'])->get();

        return response()->json($data);
    }

    public function legalDocuments(Request $request)
    {
        $q = $request->input('q');
        $sort = $request->sort;

        if ($request->filter === 'highlight') {
            $data = LegalDocumentDetail::query()
                ->where('is_highlight', 1)
                ->limit(4)
                ->get();

            return response()->json($data);
        }

        $data = LegalDocumentDetail::query()
          ->where('legal_document_id', $request->category_id)
          ->when($q, fn ($query) => $query->where('title_id', 'like', "%{$q}%"))
          ->when($request->sort, function ($query) use ($sort) {
              $query->orderBy('created_at', $sort);
          })
          ->paginate(8);

        return response()->json($data);
    }

    public function careers(Request $request)
    {
        $q = $request->input('q');
        $data = Career::query()
            ->select(['id', 'field_name_id', 'field_name_en', 'major_id', 'major_en', 'employment_status', 'location', 'slug_id', 'slug_en'])
           ->when($q, fn ($query) => $query->where('field_name_id', 'like', "%{$q}%")
                     ->orWhere('major_id', 'like', "%{$q}%")
           )
           ->paginate();

        return response()->json($data);
    }

    public function careerDetails(Request $request)
    {
        $data = Career::query()
                ->select(['id', 'slug_id', 'slug_en', 'field_name_id', 'field_name_en', 'description_id', 'description_en', 'google_form_link'])
                ->where('slug_id', $request->slug)
                ->orWhere('slug_en', $request->slug)
                ->first();

        return response()->json($data);
    }

    public function ourClients()
    {
        $Klien_Kami_Banner = 8;

        // Ambil banner yang sesuai
        $banner = DB::table('media')
            ->select('id', 'path')
            ->where('category_id', $Klien_Kami_Banner)
            ->first();

        $pageSettings = Client::query()->first();

        $clients = Sector::query()->with(['corporateGroups' => function ($query) {
            $query->with('companies');
        }])->get();

        return response()->json([
            'banner' => $banner,
            'page_settings' => $pageSettings,
            'clients' => $clients,
        ]);
    }

    public function directoryCategories(Request $request)
    {
        $data = Directory::query()->get();

        return response()->json($data);
    }

    public function directories(Request $request)
    {
        $q = $request->input('q');
        $sort = $request->sort;

        $data = DirectoryDetail::query()
          ->where('directory_id', $request->directory_id)
          ->when($q, fn ($query) => $query->where('title_id', 'like', "%{$q}%"))
          ->when($request->sort, function ($query) use ($sort) {
              $query->orderBy('created_at', $sort);
          })
          ->paginate(8);

        return response()->json($data);
    }

    public function jasaDanLayanan()
    {
        $Jenis_Layanan_Banner = 5;

        // Ambil banner yang sesuai
        $banner = DB::table('media')
            ->select('id', 'path')
            ->where('category_id', $Jenis_Layanan_Banner)
            ->first();

        $data = Service::query()->first();

        $data->image = $banner->path ?? null;

        return response()->json($data);
    }

    public function jasaDanLayananCard(Request $request)
    {
        $data = ServiceCategory::where('slug', $request->category)
        ->with(['tabs' => function ($query) {
            $query->with('serviceCards');
        }])->get();

        return response()->json($data);
    }

    public function detailJasaDanLayananCard(Request $request)
    {
        $activeCard = ServiceCard::query()
                ->where('slug_id', $request->slug)
                ->orWhere('slug_en', $request->slug)
                ->first();

        $activeTab = Tab::query()->where('id', $activeCard->tab_id)->first();

        $category = ServiceCategory::query()
            ->select(['id', 'category_name_id', 'category_name_en', 'slug'])
            ->where('id', $activeTab->service_category_id)
            ->with(['tabs' => function ($query) use ($activeTab) {
                $query->select([
                    'id',
                    'tab_name_id',
                    'tab_name_en',
                    'description_id',
                    'description_en',
                    'service_category_id',
                    DB::raw("CASE WHEN id = {$activeTab->id} THEN true ELSE false END as is_active"),
                ]);
            }])
            ->first();

        $tabIds = $category->tabs->pluck('id')->toArray();

        $cards = ServiceCard::query()
           ->whereIn('tab_id', $tabIds)
           ->whereNull('parent_id')
           ->with(['serviceMediaCards', 'children'])
           ->get()
           ->map(function ($card) use ($activeCard) {
               $card->is_active = $card->id === $activeCard->id;

               return $card;
           });

        $category->background = $activeCard->background;

        return response()->json([
            'header' => $category,
            'cards' => $cards,
        ]);
    }
}

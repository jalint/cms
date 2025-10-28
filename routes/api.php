<?php

use App\Http\Controllers\API\ContentManagementSystemController;
use Illuminate\Support\Facades\Route;

/*
 * Homepage
 */
Route::get('contact-us', [ContentManagementSystemController::class, 'contactUs']);
Route::get('news', [ContentManagementSystemController::class, 'news']);
Route::get('news/{slug}', [ContentManagementSystemController::class, 'newsDetails']);
Route::get('homepage/testimonials', [ContentManagementSystemController::class, 'testimonials']);
Route::get('homepage/services', [ContentManagementSystemController::class, 'homepageServices']);
Route::get('homepage/latest-news', [ContentManagementSystemController::class, 'latestNews']);
Route::get('careers', [ContentManagementSystemController::class, 'careers']);
Route::get('careers/{slug}', [ContentManagementSystemController::class, 'careerDetails']);

/*
 * Company Profile
 */
Route::get('company-profiles', [ContentManagementSystemController::class, 'companyProfiles']);
Route::get('company-profiles/milestones', [ContentManagementSystemController::class, 'milestones']);
Route::get('company-profiles/parameters', [ContentManagementSystemController::class, 'parameterCharts']);
Route::get('company-profiles/customer-distributions', [ContentManagementSystemController::class, 'customerDistributions']);
Route::get('company-profiles/customer-distributions/map', [ContentManagementSystemController::class, 'customerDistributionData']);
Route::get('company-profiles/organization-structures', [ContentManagementSystemController::class, 'organizationStructures']);
Route::get('company-profiles/policies', [ContentManagementSystemController::class, 'companyPolicies']);
Route::get('company-profiles/legals/category', [ContentManagementSystemController::class, 'legalDocumentCategory']);
Route::get('company-profiles/legals', [ContentManagementSystemController::class, 'legalDocuments']);

/*
 * Our Clients
 */
Route::get('clients', [ContentManagementSystemController::class, 'ourClients']);

<?php

use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Main Controllers (Auth/Main)
use App\Http\Controllers\Auth\main\DashboardController;
use App\Http\Controllers\Auth\main\CustomerController;
use App\Http\Controllers\Auth\main\PlanController;
use App\Http\Controllers\Auth\main\DealController;
use App\Http\Controllers\Auth\main\TodoController;
use App\Http\Controllers\Auth\main\LeadController;
use App\Http\Controllers\Auth\main\PipelineController;
use App\Http\Controllers\Auth\main\CampaignController;
use App\Http\Controllers\Auth\main\ProjectController;
use App\Http\Controllers\Auth\main\RoleController;
use App\Http\Controllers\Auth\main\PermissionController;
use App\Http\Controllers\Auth\main\SystemUserController;
use App\Http\Controllers\Auth\main\ActivityController;
use App\Http\Controllers\Auth\main\TaskController;
use App\Http\Controllers\Auth\main\ProposalController;
use App\Http\Controllers\Auth\main\ContractController;
use App\Http\Controllers\Auth\main\ContactStageController;
use App\Http\Controllers\Auth\main\LostReasonController;
use App\Http\Controllers\Auth\main\SourceController;
use App\Http\Controllers\Auth\main\CallController;
use App\Http\Controllers\Auth\main\EstimationController;
use App\Http\Controllers\Auth\main\InvoiceController;
use App\Http\Controllers\Auth\main\PaymentController;
use App\Http\Controllers\Auth\main\AnalyticsController;
use App\Http\Controllers\Auth\main\OrganizationController;
use App\Http\Controllers\Auth\main\SettingController;
use App\Http\Controllers\Auth\main\ReportController;


Route::get('/', function () {
    return view('frontend.welcome');
});

Route::middleware(['auth', 'check_permission'])->group(function () {
    //Menu  
    // Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/mydashboard', [DashboardController::class, 'dashboard'])->name('my_dashboard');

    // layout

    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

    // pages
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

    // authentication
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

    // cards
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

    // User Interface
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

    // extended ui
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

    // icons
    Route::get('/icons/icons-ri', [RiIcons::class, 'index'])->name('icons-ri');

    // form elements
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

    // form layouts
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

    // tables
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');

    //Profile 
    Route::get('/user_profile_show', [ProfileController::class, 'user_profile'])->name('user_profile_show');
    Route::get('/user_profile_edit', [ProfileController::class, 'user_profile_edit'])->name('user_profile_edit');
    Route::put('/user_profile_update', [ProfileController::class, 'user_profile_update'])->name('user_profile_update');
    //Organization
    Route::resource('organizations', OrganizationController::class);

    //Customer
    Route::get('customers/filter', [CustomerController::class, 'filter'])->name('customers.filter');
    Route::get('customers/export/pdf', [CustomerController::class, 'exportPdf'])->name('customers.export.pdf');
    Route::get('customers/export/excel', [CustomerController::class, 'exportExcel'])->name('customers.export.excel');
    Route::get('/customer-memo/{id}', [CustomerController::class, 'memo'])->name('customer_memos.memo');
    Route::post('/customer-memo-store/{id}', [CustomerController::class, 'memoStore'])->name('customer_memos.memo.store');
    Route::get('/customer-memo-edit/{id}', [CustomerController::class, 'memoEdit'])->name('customer_memos.memo.edit');
    Route::put('/customer-memo-update/{id}', [CustomerController::class, 'memoUpdate'])->name('customer_memos.memo.update');
    Route::delete('/customer-memo-delete/{id}', [CustomerController::class, 'memoDestroy'])->name('customer_memos.memo.destroy');
    Route::post('/customers/delete-selected', [CustomerController::class, 'deleteSelected'])->name('customers.deleteSelected');
    Route::post('/customers/{customer}/mark-read', [CustomerController::class, 'markRead'])->name('customers.markRead');
    Route::resource('customers', CustomerController::class);

    //Plan
    Route::get('plans/filter', [PlanController::class, 'filter'])->name('plans.filter');
    Route::get('plans/export/pdf', [PlanController::class, 'exportPdf'])->name('plans.export.pdf');
    Route::get('plans/export/excel', [PlanController::class, 'exportExcel'])->name('plans.export.excel');
    Route::get('/plan-memo/{id}', [PlanController::class, 'memo'])->name('plan_memos.memo');
    Route::post('/plan-memo-store/{id}', [PlanController::class, 'memoStore'])->name('plan_memos.memo.store');
    Route::get('/plan-memo-edit/{id}', [PlanController::class, 'memoEdit'])->name('plan_memos.memo.edit');
    Route::put('/plan-memo-update/{id}', [PlanController::class, 'memoUpdate'])->name('plan_memos.memo.update');
    Route::delete('/plan-memo-delete/{id}', [PlanController::class, 'memoDestroy'])->name('plan_memos.memo.destroy');
    Route::post('/plans/delete-selected', [PlanController::class, 'deleteSelected'])->name('plans.deleteSelected');
    Route::post('/plans/{customer}/mark-read', [PlanController::class, 'markRead'])->name('plans.markRead');
    Route::resource('plans', PlanController::class);

    Route::resource('activities', ActivityController::class);
    Route::resource('deals', DealController::class);
    Route::delete('todos/delete_selected', [TodoController::class, 'deleteSelected'])->name('todos.delete_selected');
    Route::resource('todos', TodoController::class);
    Route::resource('leads', LeadController::class);

    Route::resource('pipelines', PipelineController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('proposals', ProposalController::class);
    Route::resource('contact_stages', ContactStageController::class);
    Route::resource('lost_reasons', LostReasonController::class);
    Route::resource('sources', SourceController::class);
    Route::resource('contracts', ContractController::class);
    Route::resource('estimations', EstimationController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('payments', PaymentController::class);

    Route::resource('calls', CallController::class);
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::resource('campaigns', CampaignController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('system_users', SystemUserController::class);

    Route::get('/reports/customer', [ReportController::class, 'customerReport'])->name('reports.customer');
    Route::get('reports/customer/pdf', [ReportController::class, 'customerReportPDF'])->name('reports.customer.pdf');
    Route::get('/reports/plan', [ReportController::class, 'planReport'])->name('reports.plan');
    Route::get('reports/plan/pdf', [ReportController::class, 'planReportPDF'])->name('reports.plan.pdf');


    Route::get('/setting_menu', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/setting_theme', [SettingController::class, 'theme'])->name('settings.theme');
    Route::post('/setting_theme/update', [SettingController::class, 'updateTheme'])->name('settings.theme.update');
    Route::get('/setting_logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::post('/settings_logs/delete', [SettingController::class, 'deleteLogs'])->name('settings.logs.delete');
    Route::get('/setting_database', [SettingController::class, 'database'])->name('settings.database');
    Route::post('/setting_database/database/download', [SettingController::class, 'downloadDatabase'])->name('settings.database.download');
    Route::post('/setting_database/database/download-table', [SettingController::class, 'downloadTable'])->name('settings.database.downloadTable');
    Route::get('/setting_language', [SettingController::class, 'language'])->name('settings.language');
    Route::post('/setting_language/update', [SettingController::class, 'updateLanguage'])->name('settings.language.update');

    //sidebar hide  
    Route::get('/organization_menu', fn() => abort(403))->name('menu.organization')->middleware(['auth', 'permission:menu.organization']);
    Route::get('/sales_menu', fn() => abort(403))->name('menu.sales')->middleware(['auth', 'permission:menu.sales']);
    Route::get('/marketing_menu', fn() => abort(403))->name('menu.market')->middleware(['auth', 'permission:menu.market']);
    Route::get('/project_menu', fn() => abort(403))->name('menu.project')->middleware(['auth', 'permission:menu.project']);
    Route::get('/finance_menu', fn() => abort(403))->name('menu.finance')->middleware(['auth', 'permission:menu.finance']);
});

require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use  App\Http\Controllers\DashboardController;

use Illuminate\Http\Request;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailSettingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\WhyNexaController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\ThemeColorController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\SupportConversationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AgencyProjectController;
use App\Http\Controllers\AdminCommerceController;




Route::get('/test-ddd', function () {
    dd('working');
});
Route::get('/language/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, ['en', 'ar'], true), 404);

    $request->session()->put('locale', $locale);

    return redirect()->back();
})->name('language.switch');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/', [HomeController::class, 'home'])->name('website.home');
Route::get('/about', [HomeController::class, 'about'])->name('website.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('website.contact');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('website.testimonials');
Route::get('/offers', [OfferController::class, 'pricing'])->name('website.offers');
Route::get('/offers/{offer:slug}', [OfferController::class, 'show'])->name('website.offers.show');
Route::get('/service', [ServiceDetailController::class, 'webIndex'])->name('website.services');
Route::get('/industries', [IndustryController::class, 'webIndex'])->name('website.industries');
Route::get('/case-studies', [CaseStudyController::class, 'webIndex'])->name('website.case-studies');
Route::get('/portfolio', [PortfolioController::class, 'webIndex'])->name('website.portfolio');
Route::get('/portfolio-details', [PortfolioController::class, 'webShow'])->name('website.portfolio-details');
Route::get('/portfolio-details/{portfolio:slug}', [PortfolioController::class, 'webShow'])->name('website.portfolio-details.show');
Route::get('/blog', [BlogController::class, 'webIndex'])->name('website.blog');
Route::post('/blog-submit', [BlogController::class, 'storePublic'])->name('website.blog.store');
Route::get('/blog-details', [BlogController::class, 'webShow'])->name('website.blog-details');
Route::get('/blog-details/{blog:slug}', [BlogController::class, 'webShow'])->name('website.blog-details.show');
Route::get('/service-details', [ServiceDetailController::class, 'webShow'])->name('website.service-details');
Route::get('/service-details/{serviceDetail:slug}', [ServiceDetailController::class, 'webShow'])->name('website.service-details.show');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'resetForgottenPassword'])->name('password.update');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public Service Request Submission
Route::post('/request-service', [ServiceRequestController::class, 'store'])->name('services.store.public');
Route::post('/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'store'])->name('newsletter-subscriptions.store');
Route::post('/support-chat', SupportChatController::class)->middleware('throttle:20,1')->name('support-chat');
Route::get('/quote-generator/{token}', [QuoteRequestController::class, 'show'])->name('website.quote-generator.show');
Route::get('/quote-generator/{token}/proposal', [QuoteRequestController::class, 'proposal'])->name('website.quote-generator.proposal');
Route::get('/quote-generator/{token}/proposal/download', [QuoteRequestController::class, 'download'])->name('website.quote-generator.download');

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/service-requests', [UserDashboardController::class, 'serviceRequests'])->name('user.service-requests');
    Route::get('/user/quote-requests', [UserDashboardController::class, 'quoteRequests'])->name('user.quote-requests');
    Route::get('/user/orders', [UserDashboardController::class, 'orders'])->name('user.orders');
    Route::get('/user/subscriptions', [UserDashboardController::class, 'subscriptions'])->name('user.subscriptions');
    Route::get('/user/projects', [AgencyProjectController::class, 'userIndex'])->name('user.projects');
    Route::get('/user/projects/{project}', [AgencyProjectController::class, 'userShow'])->name('user.projects.show');
    Route::post('/user/projects/{project}/messages', [AgencyProjectController::class, 'userMessage'])->name('user.projects.messages');
    Route::get('/user/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');
    Route::get('/user/support-chat', [SupportConversationController::class, 'userShow'])->name('user.support-chat');
    Route::get('/user/support-chat/messages', [SupportConversationController::class, 'userMessages'])->name('user.support-chat.messages');
    Route::post('/user/support-chat', [SupportConversationController::class, 'userStore'])->name('user.support-chat.store');
    Route::get('/user/profile', [ProfileController::class, 'userEdit'])->name('user.profile.edit');
    Route::put('/user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.password.update');
    Route::patch('/user/notifications/read', function (Request $request) {
        $request->user()->unreadNotifications->markAsRead();

        return back();
    })->name('user.notifications.read');
    Route::get('/user/notifications/{notification}', function (Request $request, string $notification) {
        $item = $request->user()->notifications()->findOrFail($notification);
        $item->markAsRead();

        return redirect($item->data['action_url'] ?? route('user.notifications'));
    })->name('user.notifications.open');
    Route::get('/quote-generator', [QuoteRequestController::class, 'create'])->name('website.quote-generator');
    Route::post('/quote-generator', [QuoteRequestController::class, 'store'])->name('website.quote-generator.store');
    Route::get('/checkout/{offer:slug}', [CheckoutController::class, 'create'])->name('website.checkout');
    Route::post('/checkout/{offer:slug}', [CheckoutController::class, 'store'])->name('website.checkout.store');
});

// Service CRUD & Dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('requests.index');
    Route::get('/dashboard/support-chats', [SupportConversationController::class, 'adminIndex'])->name('support-chats.index');
    Route::get('/dashboard/support-chats/{conversation}', [SupportConversationController::class, 'adminShow'])->name('support-chats.show');
    Route::get('/dashboard/support-chats/{conversation}/messages', [SupportConversationController::class, 'adminMessages'])->name('support-chats.messages');
    Route::post('/dashboard/support-chats/{conversation}', [SupportConversationController::class, 'adminStore'])->name('support-chats.store');
    Route::patch('/requests/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])->name('requests.status.update');
    Route::get('/dashboard/quotes', [QuoteRequestController::class, 'index'])->name('quotes.index');
    Route::get('/dashboard/quotes/{quote}', [QuoteRequestController::class, 'dashboardShow'])->name('quotes.show');
    Route::patch('/dashboard/quotes/{quote}/status', [QuoteRequestController::class, 'updateStatus'])->name('quotes.status.update');
    Route::get('/dashboard/offers', [OfferController::class, 'adminIndex'])->name('offers.admin.index');
    Route::get('/dashboard/offers/create', [OfferController::class, 'create'])->name('offers.admin.create');
    Route::post('/dashboard/offers', [OfferController::class, 'store'])->name('offers.admin.store');
    Route::get('/dashboard/offers/{offer}/edit', [OfferController::class, 'edit'])->name('offers.admin.edit');
    Route::put('/dashboard/offers/{offer}', [OfferController::class, 'update'])->name('offers.admin.update');
    Route::delete('/dashboard/offers/{offer}', [OfferController::class, 'destroy'])->name('offers.admin.destroy');
    Route::get('/dashboard/orders', [AdminCommerceController::class, 'orders'])->name('orders.admin.index');
    Route::get('/dashboard/subscriptions', [AdminCommerceController::class, 'subscriptions'])->name('subscriptions.admin.index');
    Route::get('/dashboard/projects', [AgencyProjectController::class, 'adminIndex'])->name('projects.admin.index');
    Route::get('/dashboard/projects/{project}', [AgencyProjectController::class, 'adminShow'])->name('projects.admin.show');
    Route::patch('/dashboard/projects/{project}', [AgencyProjectController::class, 'update'])->name('projects.admin.update');
    Route::post('/dashboard/projects/{project}/messages', [AgencyProjectController::class, 'adminMessage'])->name('projects.admin.messages');
    
    Route::resource('services', ServiceController::class);
    Route::resource('dashboard/service-details', ServiceDetailController::class)->names('service-details');
    Route::resource('blogs', BlogController::class);
    Route::resource('logos', LogoController::class);
    Route::resource('reviews', ReviewController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('portfolios', PortfolioController::class)->except(['show']);
    Route::resource('dashboard/industries', IndustryController::class)->except(['show'])->names('industries');
    Route::resource('dashboard/case-studies', CaseStudyController::class)->except(['show'])->names('case-studies');
    Route::resource('dashboard/why-nexa', WhyNexaController::class)->except(['show'])->names('why-nexa');
    Route::get('dashboard/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'index'])->name('newsletter-subscriptions.index');
    Route::get('dashboard/newsletter-subscriptions/download', [NewsletterSubscriptionController::class, 'download'])->name('newsletter-subscriptions.download');
    Route::get('dashboard/theme-colors', [ThemeColorController::class, 'edit'])->name('theme-colors.edit');
    Route::put('dashboard/theme-colors', [ThemeColorController::class, 'update'])->name('theme-colors.update');
    Route::post('dashboard/theme-colors/reset', [ThemeColorController::class, 'reset'])->name('theme-colors.reset');
    Route::resource('settings', CompanySettingController::class);
});

Route::get('/{page}', [HomeController::class, 'page'])->where('page', '.*');

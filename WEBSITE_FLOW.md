# Multitechwave Website Flow

This document reflects the current working flow of the website.

## 1. Public Website Flow

Visitor lands on:

`/` Home

Home page loads dynamic content from:

- Services with service details
- Active text reviews
- Featured active portfolios, with fallback to latest active portfolios
- Active/published blogs
- Active Why Nexa items
- Partner logos

Home page section flow:

1. Hero section
2. Service request form
3. Services slider
4. Why Choose Us / stats
5. Trusted logos slider
6. Featured portfolio
7. Client reviews slider
8. Blog slider
9. Global FAQs
10. Footer
11. Floating contact / quote button / support chat

Primary public navigation:

- `/about`
- `/service`
- `/industries`
- `/case-studies`
- `/portfolio`
- `/testimonials`
- `/blog`
- `/contact`
- `/quote-generator` requires login

Fallback page route:

- `/{page}` loads `resources/views/website/{page}.blade.php` if the view exists.

## 2. Services Flow

Public services list:

`/service`

Controller:

`ServiceDetailController@webIndex`

Data:

- All services
- Loaded with related detail
- Ordered by `order`, then latest

Service detail:

`/service-details/{serviceDetail:slug}`

Controller:

`ServiceDetailController@webShow`

Behavior:

- If slug is provided, show that service detail
- If no slug is provided, show latest service detail

## 3. Portfolio Flow

Portfolio listing:

`/portfolio`

Controller:

`PortfolioController@webIndex`

Data:

- Active portfolios only
- Ordered by `sort_order`, then latest

Portfolio detail:

`/portfolio-details/{portfolio:slug}`

Controller:

`PortfolioController@webShow`

Behavior:

- Shows active portfolio only
- Loads two related active portfolios
- If no slug is provided, shows first active portfolio by sort/latest

## 4. Blog Flow

Blog listing:

`/blog`

Controller:

`BlogController@webIndex`

Data:

- Active blogs only
- Published blogs only
- Blogs with `published_at` empty are also allowed
- Ordered by published date, then latest

Blog detail:

`/blog-details/{blog:slug}`

Controller:

`BlogController@webShow`

Behavior:

- Blocks inactive/unpublished blogs
- Increments views on detail page
- Loads related active/published blogs
- If no slug is provided, shows latest active/published blog

## 5. Testimonials Flow

Testimonials page:

`/testimonials`

Controller:

`HomeController@testimonials`

Data:

- Active reviews
- Text reviews only
- Ordered by `sort_order`, then latest

Home page review slider uses the same review data style as testimonials cards.

## 6. Contact Flow

Contact page:

`/contact`

Controller:

`HomeController@contact`

Data:

- Services
- Latest company setting

Contact and floating forms can submit service requests through:

`POST /request-service`

Controller:

`ServiceRequestController@store`

Important behavior:

- User must be logged in
- If guest submits, they are redirected to `/login`
- Request is saved with status `submitted`
- Notification email is sent to configured company/admin email
- User receives notification
- WhatsApp notification is attempted

## 7. Quote Generator Flow

Quote generator page:

`/quote-generator`

Access:

- Authenticated users only

Controller:

`QuoteRequestController@create`

Data:

- Services
- Budget options
- Timeline options

Quote submit:

`POST /quote-generator`

Controller:

`QuoteRequestController@store`

Behavior:

1. Validates user quote data
2. Finds selected service
3. Generates instant estimate
4. Creates quote request with public token and reference
5. Stores deliverables, assumptions, and next steps
6. Sends emails to client and company
7. Creates user notifications
8. Sends WhatsApp notifications if possible
9. Redirects to proposal page

Quote proposal:

`/quote-generator/{token}/proposal`

Quote result:

`/quote-generator/{token}`

Quote PDF download:

`/quote-generator/{token}/proposal/download`

## 8. Authentication Flow

Login:

`/login`

Register:

`/register`

Forgot password:

`/forgot-password`

Behavior:

- Logged-in users are redirected away from login/register
- Admin users go to `/dashboard`
- Normal users go to `/user/dashboard`
- Registration creates a normal user role and logs them in
- Forgot password uses email OTP
- OTP expires after 10 minutes

Logout:

`POST /logout`

Redirects to home page.

## 9. User Dashboard Flow

User dashboard:

`/user/dashboard`

Controller:

`UserDashboardController@index`

Shows:

- User service requests
- User quote requests
- Latest service request
- Latest quote request
- Request status counts
- Recent notifications
- Recent request activity

User pages:

- `/user/service-requests`
- `/user/quote-requests`
- `/user/notifications`
- `/user/support-chat`
- `/user/profile`

Notifications:

- `/user/notifications` marks unread notifications as read
- Opening a notification marks it read and redirects to its action URL if available

Support chat:

- User sends messages from `/user/support-chat`
- Admin replies from dashboard support chats

## 10. Admin Dashboard Flow

Admin dashboard:

`/dashboard`

Access:

- Authenticated admin only

Controller:

`DashboardController@index`

Shows:

- Counts for services, service details, blogs, logos, requests, settings
- Monthly activity chart
- Recent blogs
- Recent services
- Recent service requests
- Content mix

Admin management modules:

- Services: `/services`
- Service details: `/dashboard/service-details`
- Blogs: `/blogs`
- Logos: `/logos`
- Reviews: `/reviews`
- FAQs: `/faqs`
- Portfolios: `/portfolios`
- Industries: `/dashboard/industries`
- Case studies: `/dashboard/case-studies`
- Why Nexa: `/dashboard/why-nexa`
- Newsletter subscriptions: `/dashboard/newsletter-subscriptions`
- Theme colors: `/dashboard/theme-colors`
- Settings: `/settings`
- Service requests: `/requests`
- Quote requests: `/dashboard/quotes`
- Support chats: `/dashboard/support-chats`

## 11. Request Status Flow

Service request status update:

`PATCH /requests/{serviceRequest}/status`

Quote request status update:

`PATCH /dashboard/quotes/{quote}/status`

Behavior:

- Admin updates status
- User notification is created
- WhatsApp message is attempted
- Quote `proposal_sent` status links user to proposal page

## 12. Shared Layout Flow

All public pages use:

`resources/views/layouts/website.blade.php`

Layout includes:

- SEO metadata
- Schema JSON-LD
- Header
- Page content
- Global FAQs unless hidden
- Footer
- Floating contact
- Support chat
- Tawk chat
- Main JS/CSS assets

Global SEO data includes:

- Page title
- Description
- Keywords
- Canonical URL
- Open Graph image
- Organization schema
- WebSite schema
- WebPage schema
- Breadcrumb schema

## 13. Current Home Page Data Summary

Home page is controlled by:

`HomeController@home`

Loaded models:

- `Logo`
- `Service`
- `Review`
- `Portfolio`
- `Blog`
- `WhyNexa`

Rendered view:

`resources/views/website/home.blade.php`

Important partials:

- Header: `resources/views/partials/website/header.blade.php`
- Review slider: `resources/views/partials/website/review-slider.blade.php`
- Blog slider: `resources/views/partials/website/blog-slider.blade.php`
- FAQs: `resources/views/partials/website/faqs.blade.php`
- Footer: `resources/views/partials/website/footer.blade.php`
- Floating contact: `resources/views/partials/website/floating-contact.blade.php`
- Support chat: `resources/views/partials/website/support-chat.blade.php`

## 14. Main Conversion Flow

Visitor journey:

1. Visitor lands on home page
2. Visitor reviews services, portfolio, testimonials, blogs
3. Visitor clicks service, portfolio, blog, contact, or quote
4. If submitting service request or quote, user must login/register
5. User submits request
6. Admin receives request in dashboard
7. User receives notification/email/WhatsApp where configured
8. Admin updates status
9. User tracks progress from user dashboard


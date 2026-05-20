# Premium SaaS Agency UI/UX System

This document defines the target UI/UX direction for the current Multitechwave Laravel website as a modern, futuristic SaaS digital agency platform.

## 1. Brand Direction

Website type:

Professional SaaS digital agency platform for:

- Website Development
- Laravel Development
- SEO Services
- App Development
- UI/UX Design
- SaaS Development

Main user goals:

- Browse services
- View offers/packages
- Subscribe online
- Pay online
- Access dashboard
- Track projects
- Manage subscriptions

Visual feeling:

- Premium
- Futuristic
- Dark SaaS
- Conversion-focused
- Developer agency
- Product platform, not simple brochure website

No personal branding or profile-photo driven design. Use initials, abstract icons, service icons, product cards, dashboard previews, and platform-style visuals.

## 2. Color System

Primary background:

- `#070B14`

Secondary background:

- `#0F172A`

Panel background:

- `rgba(15, 23, 42, 0.72)`
- `rgba(7, 11, 20, 0.84)`

Accent colors:

- Neon Blue: `#3B82F6`
- Purple: `#8B5CF6`
- Pink: `#EC4899`

Text:

- Primary: `#FFFFFF`
- Secondary: `#94A3B8`
- Muted: `#64748B`

Border glow:

- `rgba(255, 255, 255, 0.08)`
- `rgba(59, 130, 246, 0.28)`
- `rgba(139, 92, 246, 0.28)`

Gradient examples:

- `linear-gradient(135deg, #3B82F6, #8B5CF6)`
- `linear-gradient(135deg, #8B5CF6, #EC4899)`
- `radial-gradient(circle at top, rgba(59,130,246,.28), transparent 34%)`

## 3. Typography

Use modern SaaS typography:

- Hero headings: 56px to 78px desktop, 38px to 46px mobile
- Section headings: 36px to 52px desktop, 28px to 34px mobile
- Card headings: 20px to 26px
- Body: 15px to 17px
- Small metadata: 12px to 13px uppercase

Text should feel sharp and premium:

- No negative letter spacing
- Tight but readable line-height
- Strong contrast
- Short, conversion-focused copy blocks

## 4. Spacing System

Use consistent spacing:

- Page section desktop padding: 96px to 140px
- Page section tablet padding: 72px to 96px
- Page section mobile padding: 44px to 64px
- Card padding desktop: 28px to 40px
- Card padding mobile: 18px to 24px
- Grid gap desktop: 24px to 32px
- Grid gap mobile: 14px to 18px

Mobile rules:

- Full-width containers with 16px side padding
- No horizontal overflow
- Cards stack cleanly
- Buttons touch-friendly at 46px minimum height

## 5. Reusable Components

### Glass Card

Used for services, offers, testimonials, dashboards, and contact cards.

Style:

- Dark translucent background
- Soft border
- Inner glow
- Hover lift
- Subtle 3D transform

CSS direction:

```css
.glass-card {
  background:
    radial-gradient(circle at 18% 0%, rgba(59, 130, 246, 0.16), transparent 32%),
    linear-gradient(145deg, rgba(15, 23, 42, 0.92), rgba(7, 11, 20, 0.98));
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 24px;
  box-shadow: 0 24px 70px rgba(0, 0, 0, 0.34);
}
```

### Neon Button

Primary CTA:

- Gradient fill
- Bright text
- Soft glow
- Hover lift

Secondary CTA:

- Transparent dark
- Glowing border
- Light text

### Badge

Used for section labels, popular plans, statuses, and categories.

Style:

- Small uppercase text
- Rounded pill
- Neon tint background
- Thin glowing border

### Dashboard Preview

Used in hero and platform pages.

Elements:

- Sidebar
- Chart cards
- Activity feed
- Project progress rows
- Revenue/subscription widget
- Floating stat badges

## 6. Page System

## Home Page

### Hero Section

Purpose:

Immediately position the website as a premium digital SaaS agency platform.

Layout:

- Left: headline, paragraph, CTA buttons, trust metrics
- Right: animated dashboard preview
- Background: dark radial gradients and subtle grid/dots

Content:

- Large bold heading
- Animated glowing gradient words
- CTAs:
  - Explore Offers
  - Start Project
- Dashboard preview showing projects, subscriptions, invoices, and progress

Mobile:

- Hero text first
- Dashboard preview below
- Buttons stacked or two-column if enough space

### Trust Section

Elements:

- Trusted by businesses worldwide
- Logo slider
- Stats:
  - Projects completed
  - Active clients
  - Years experience

Mobile:

- Two logos per row/slide
- Stats in 2-column grid

### Services Section

Services:

- Website Development
- SEO Optimization
- Laravel Development
- SaaS Applications
- Mobile Apps
- UI/UX Design

Card content:

- Icon
- Service title
- Short description
- Explore button
- Glow hover effect

Desktop:

- 3-column grid

Tablet:

- 2-column grid

Mobile:

- 1-column grid or smooth slider

### Featured Offers Section

Offer cards:

1. 5 Page Dynamic Website — 200 AED
2. Ecommerce Website — 1200 AED
3. SEO Starter Package — 150 AED
4. Laravel SaaS System — 3000 AED

Each card includes:

- Price
- Features list
- Delivery time
- Popular badge
- Subscribe button
- Hover glow

Recommended card:

- Stronger border glow
- Popular badge
- Slight elevation

### Portfolio Section

Layout:

- Category filters
- Large project thumbnails
- Dark overlay on hover
- Service/category label
- Project title
- View details CTA

Desktop:

- Masonry or 2/3 column premium grid

Mobile:

- Single-column cards

### Testimonials Section

Use the same 4D testimonial card system across home and testimonials page.

Elements:

- Initial avatar, no profile images
- Name
- Role/designation
- Rating
- Badge
- Review text
- Animated slider on home
- Grid with load more on testimonials page

### Process Section

Timeline steps:

1. Select Offer
2. Subscribe
3. Submit Requirements
4. Development
5. Review
6. Delivery

Desktop:

- Horizontal timeline

Mobile:

- Vertical step cards

### Blog Section

Card content:

- Featured image
- Category
- Title
- Short excerpt
- Read more button

### FAQ Section

Use animated accordion:

- Dark glass panels
- Plus/minus icon
- Smooth open/close

### CTA Section

Headline:

Start Your Project Today

Elements:

- Short conversion copy
- CTA button: Explore Offers
- Secondary CTA: Contact Us
- Glowing background

### Footer

Columns:

- Brand summary
- Quick links
- Services
- Offers
- Contact info
- Newsletter
- Social icons

## Services Page

Sections:

1. Hero banner
2. Service filters
3. Service cards
4. Sticky sidebar CTA
5. Related offers
6. FAQ
7. Final CTA

Interactions:

- Filter by category
- Hover cards
- CTA to offer or quote

## Offers / Pricing Page

Sections:

1. Pricing hero
2. Monthly/yearly toggle
3. Neon pricing cards
4. Recommended badges
5. Feature comparison table
6. Addons section
7. FAQ
8. CTA

Offer groups:

- Basic Website
- Business Website
- Ecommerce Store
- Laravel SaaS
- SEO Plans

## Offer Detail Page

Sections:

1. Offer hero
2. Pricing summary
3. Features
4. Technology stack
5. Delivery timeline
6. Screenshots/mockups
7. FAQ
8. Reviews
9. Sticky pricing sidebar
10. Subscribe CTA

Sticky sidebar:

- Price
- Delivery time
- Subscribe button
- Included features

## Checkout Page

Sections:

- Billing details
- Order summary
- Coupon code
- Addons
- Payment methods
- Secure checkout indicators

Payment methods:

- Stripe
- PayPal
- Credit Card

UI:

- Dark glass checkout shell
- Right sticky order summary
- Trust indicators
- Clear total price

## Authentication Pages

Pages:

- Login
- Register
- Forgot password

Layout:

- Split screen desktop
- Form card on one side
- SaaS visual/dashboard preview on the other
- Full-width form card on mobile

Elements:

- Neon form fields
- Social login buttons
- Floating gradient elements
- Password visibility toggle

## User Dashboard

Sidebar:

- Dashboard
- Projects
- Orders
- Subscriptions
- Messages
- Invoices
- Settings

Dashboard widgets:

- Active subscriptions
- Projects
- Notifications
- Invoices
- Payments
- Files
- Messages
- Support tickets
- Statistics cards
- Progress charts
- Timeline
- Activity logs

Mobile:

- Collapsible sidebar
- Bottom navigation or hamburger drawer
- Cards stack vertically

## Project Management Page

Features:

- Project timeline
- Progress tracking
- File uploads
- Comments/chat
- Revision requests
- Milestones
- Deliverables

Statuses:

- Pending
- In Progress
- Review
- Revision
- Completed

Layout:

- Main project details
- Right status/timeline panel
- Tabs for files, messages, invoices, requirements

## Admin Dashboard

Admin modules:

- User management
- Service management
- Offer management
- Subscription management
- Payment management
- Analytics
- Orders
- Notifications
- Coupons
- Project tracking

UI:

- Premium dark admin panel
- Sidebar navigation
- Charts
- Tables
- Stats widgets
- Activity feeds
- Filter/search controls

## Blog Page

Sections:

- Blog hero
- Featured posts
- Categories
- Search
- Tags
- Pagination

Cards:

- Dark glass cards
- Featured image
- Category badge
- Read more CTA

## Contact Page

Sections:

- Contact hero
- Contact form
- Interactive map
- Contact cards
- WhatsApp CTA
- Social links

## 7. Animation System

Use animation carefully:

- Fade up on scroll
- Card hover lift
- Soft glowing border animation
- Dashboard preview floating motion
- Slider transitions
- Accordion open/close
- Parallax background elements

Avoid:

- Excessive motion
- Heavy animations on mobile
- Layout shifts
- Text overlap

## 8. Responsive Rules

Desktop:

- Max container: 1180px to 1320px
- Multi-column grids
- Sticky sidebars where useful

Tablet:

- 2-column cards
- Shorter hero
- Dashboard previews reduced

Mobile:

- 16px container padding
- 1-column cards
- Full-width buttons
- Touch-friendly form fields
- Hamburger menu
- Sticky mobile CTA
- No horizontal overflow
- Dashboard tables converted to cards

## 9. Current Laravel Mapping

Existing pages to upgrade:

- Home: `resources/views/website/home.blade.php`
- Services: `resources/views/website/service.blade.php`
- Service detail: `resources/views/website/service-details.blade.php`
- Portfolio: `resources/views/website/portfolio.blade.php`
- Portfolio detail: `resources/views/website/portfolio-details.blade.php`
- Testimonials: `resources/views/website/testimonials.blade.php`
- Blog: `resources/views/website/blog.blade.php`
- Blog detail: `resources/views/website/blog-details.blade.php`
- Contact: `resources/views/website/contact.blade.php`
- Quote generator: `resources/views/website/quote-generator.blade.php`
- Login: `resources/views/auth/login.blade.php`
- Register: `resources/views/auth/register.blade.php`
- Forgot password: `resources/views/auth/forgot-password.blade.php`
- User dashboard: `resources/views/user/dashboard.blade.php`
- Admin dashboard: `resources/views/dashboard/index.blade.php`

Existing shared files:

- Public layout: `resources/views/layouts/website.blade.php`
- Header: `resources/views/partials/website/header.blade.php`
- Footer: `resources/views/partials/website/footer.blade.php`
- Review slider: `resources/views/partials/website/review-slider.blade.php`
- Blog slider: `resources/views/partials/website/blog-slider.blade.php`
- Main custom CSS: `public/website/assets/css/tcw-custom.css`
- Main custom JS: `public/website/assets/js/tcw-custom.js`

## 10. Implementation Order

Recommended implementation sequence:

1. Global design tokens and reusable CSS components
2. Header and footer
3. Home page
4. Services and service details
5. Offers/pricing system
6. Checkout system
7. Auth pages
8. User dashboard
9. Project management pages
10. Admin dashboard
11. Blog and contact pages
12. Final responsive pass
13. Performance and accessibility pass


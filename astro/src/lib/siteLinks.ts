// Site menu + footer links: the legacy site's hamburger menu (Home, Help, About ›
// Copyright / Partners / Terms / Privacy, Contact Us, Donate, Promotion Materials).
// Labels are English baked HTML; `key` is the chrome i18n key that swaps them.
export interface SiteLink { href: string; key: string; label: string; external?: boolean }

export const HOME: SiteLink = { href: '/', key: 'crumb.home', label: 'Home' };
export const LANGUAGES: SiteLink = { href: '/browse/', key: 'nav.languages', label: 'Languages' };
export const COUNTRIES: SiteLink = { href: '/countries/', key: 'nav.countries', label: 'Countries' };
export const HELP: SiteLink = { href: '/help/', key: 'nav.help', label: 'Help' };

export const ABOUT_HEADING = { key: 'footer.about', label: 'About' };
export const ABOUT_LINKS: SiteLink[] = [
  { href: '/about/', key: 'nav.copyright', label: 'Copyright' },
  { href: '/about/partners/', key: 'nav.partners', label: 'Content providers and partners' },
  { href: '/about/terms/', key: 'nav.terms', label: 'Terms and Conditions' },
  { href: '/about/privacy/', key: 'nav.privacy', label: 'Privacy Policy' },
];

export const CONTACT: SiteLink = { href: '/contact/', key: 'nav.contact', label: 'Contact Us' };
export const DONATE: SiteLink = {
  href: 'https://give.sil.org/give/531194/#!/donation/checkout',
  key: 'nav.donate',
  label: 'Donate',
  external: true,
};
export const PROMOTION: SiteLink = { href: '/promotion/', key: 'nav.promotion', label: 'Promotion Materials' };

export const CONTACT_EMAIL = 'info@ScriptureEarth.org';

// Floating "Feedback" button for the soft launch (src/components/FeedbackButton.astro).
// Set enabled: false to remove it from every page. The endpoint is the Pages Function
// functions/api/feedback.js, which appends a row to a Google Sheet (feedback-sheet/README.md).
export const FEEDBACK = { enabled: true, endpoint: '/api/feedback' };

/** True when `href` is the page at `path` (both trailing-slash paths). */
export const isCurrent = (href: string, path: string) => href === path;

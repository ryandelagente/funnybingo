@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ route('page.privacy') }}/#webpage",
  "url": "{{ route('page.privacy') }}",
  "name": "Privacy Policy — Funny Bingo",
  "description": "Funny Bingo privacy policy covering data collection, cookies, Google Analytics, AdSense, and contact form data.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Privacy Policy", "item": "{{ route('page.privacy') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="content-wrap">
    <h1>Privacy Policy</h1>
    <p class="post-meta">
        <span>Last updated: {{ date('F d, Y') }}</span>
    </p>

    <p>This Privacy Policy describes how Funny Bingo ("we", "us", or "our") collects, uses, and shares information when you use our website at <strong>{{ url('/') }}</strong>.</p>

    <h2>1. Information We Collect</h2>
    <p>Funny Bingo does not require registration or account creation. We do not collect your name, email address, or any personally identifiable information through the use of the bingo application itself.</p>
    <p>However, the following information may be collected automatically:</p>
    <ul>
        <li><strong>Log Data:</strong> IP address, browser type, pages visited, time spent, and referring URL — collected by our web server and third-party analytics.</li>
        <li><strong>Cookies:</strong> Small files stored on your device used for session management and advertising purposes (see Google AdSense section below).</li>
        <li><strong>Contact Form:</strong> If you submit our contact form, we collect your name, email address, subject, and message.</li>
    </ul>

    <h2>2. Google AdSense</h2>
    <p>We use Google AdSense to display advertisements on this website. Google AdSense uses cookies to serve ads based on your prior visits to this site and other sites on the internet.</p>
    <p>Google's use of advertising cookies enables it and its partners to serve ads to you based on your visit to our site and/or other sites on the Internet. You may opt out of personalized advertising by visiting <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener">Google Ads Settings</a>.</p>
    <p>For more information on how Google uses data, visit: <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener">How Google uses data when you use our partners' sites or apps</a>.</p>

    <h2>3. Cookies</h2>
    <p>We use cookies for the following purposes:</p>
    <ul>
        <li><strong>Session cookies:</strong> To maintain your session while using the application.</li>
        <li><strong>Advertising cookies:</strong> Set by Google AdSense for targeted advertising.</li>
        <li><strong>Analytics cookies:</strong> To understand how visitors use our site.</li>
    </ul>
    <p>You can control and/or delete cookies through your browser settings. Disabling cookies may affect some functionality of the website.</p>

    <h2>4. How We Use Your Information</h2>
    <p>Information collected is used to:</p>
    <ul>
        <li>Operate and maintain the website</li>
        <li>Respond to contact form inquiries</li>
        <li>Display relevant advertisements through Google AdSense</li>
        <li>Analyze usage patterns to improve the site</li>
    </ul>

    <h2>5. Third-Party Services</h2>
    <p>We use the following third-party services that may collect data:</p>
    <ul>
        <li><strong>Google AdSense</strong> — Advertising network (<a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a>)</li>
        <li><strong>QRCode.js CDN (cdnjs)</strong> — JavaScript library for QR code generation</li>
        <li><strong>Web Speech API</strong> — Browser-native speech synthesis; no data leaves your device</li>
    </ul>

    <h2>6. Data Retention</h2>
    <p>Contact form submissions are retained for a reasonable period to respond to your inquiry and are not shared with third parties. Log data is typically retained for 30 days.</p>

    <h2>7. Children's Privacy</h2>
    <p>Funny Bingo is not directed at children under the age of 13. We do not knowingly collect personal information from children under 13. If you believe a child has provided us with personal information, please contact us and we will delete it promptly.</p>

    <h2>8. Your Rights</h2>
    <p>Depending on your location, you may have the right to:</p>
    <ul>
        <li>Access the personal data we hold about you</li>
        <li>Request deletion of your personal data</li>
        <li>Opt out of personalized advertising</li>
    </ul>
    <p>To exercise these rights, please contact us using the <a href="{{ route('page.contact') }}">Contact page</a>.</p>

    <h2>9. Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated revision date. Continued use of the site after changes constitutes your acceptance of the updated policy.</p>

    <h2>10. Contact</h2>
    <p>If you have any questions about this Privacy Policy, please <a href="{{ route('page.contact') }}">contact us</a>.</p>
</div>
@endsection

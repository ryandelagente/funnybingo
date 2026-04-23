@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "@id": "{{ route('page.terms') }}/#webpage",
  "url": "{{ route('page.terms') }}",
  "name": "Terms of Service — Funny Bingo",
  "description": "Terms of Service for Funny Bingo covering permitted use, intellectual property, disclaimers, and governing law.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Terms of Service", "item": "{{ route('page.terms') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="content-wrap">
    <h1>Terms of Service</h1>
    <p class="post-meta"><span>Last updated: {{ date('F d, Y') }}</span></p>

    <p>By accessing and using Funny Bingo ("the Site"), you agree to be bound by these Terms of Service. If you do not agree, please discontinue use of the Site.</p>

    <h2>1. Use of the Site</h2>
    <p>Funny Bingo provides a free, browser-based bingo calling and card generation tool. You may use it for personal, educational, or non-commercial event purposes. You agree not to:</p>
    <ul>
        <li>Use the site for any unlawful purpose</li>
        <li>Attempt to disrupt, hack, or overload the site's infrastructure</li>
        <li>Scrape, copy, or redistribute our content without permission</li>
        <li>Use the site in a way that violates any applicable laws or regulations</li>
    </ul>

    <h2>2. Intellectual Property</h2>
    <p>All content on Funny Bingo — including the application code, blog articles, design, and branding — is the property of Ryan Jison de la Gente and is protected by copyright law. Unauthorized reproduction or distribution is strictly prohibited.</p>

    <h2>3. Disclaimer of Warranties</h2>
    <p>Funny Bingo is provided "as is" without warranties of any kind, either expressed or implied. We do not guarantee that the site will be error-free, uninterrupted, or free of viruses or other harmful components. Use at your own risk.</p>

    <h2>4. Limitation of Liability</h2>
    <p>To the fullest extent permitted by law, Funny Bingo and its creator shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of the site.</p>

    <h2>5. Advertising</h2>
    <p>This site displays advertisements served by Google AdSense. We are not responsible for the content of third-party advertisements. By using the site, you acknowledge and consent to the display of ads.</p>

    <h2>6. Third-Party Links</h2>
    <p>The Site may contain links to third-party websites. We are not responsible for the content or privacy practices of those sites. Accessing third-party links is at your own risk.</p>

    <h2>7. Changes to Terms</h2>
    <p>We reserve the right to modify these Terms at any time. Changes will be posted on this page. Your continued use of the site after changes constitutes acceptance of the revised Terms.</p>

    <h2>8. Governing Law</h2>
    <p>These Terms shall be governed by the laws of the Republic of the Philippines, without regard to its conflict of law provisions.</p>

    <h2>9. Contact</h2>
    <p>For questions regarding these Terms, please visit our <a href="{{ route('page.contact') }}">Contact page</a>.</p>
</div>
@endsection

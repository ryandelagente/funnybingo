@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "@id": "{{ route('page.contact') }}/#webpage",
  "url": "{{ route('page.contact') }}",
  "name": "Contact Funny Bingo",
  "description": "Get in touch with the Funny Bingo team. Send questions, feedback, or suggestions.",
  "isPartOf": { "@id": "{{ url('/') }}/#website" },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Contact", "item": "{{ route('page.contact') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="content-wrap">
    <h1>Contact Us</h1>
    <p>Have a question, suggestion, or feedback about Funny Bingo? We'd love to hear from you.</p>

    <div style="background:#111827; border:1px solid #1f2937; border-radius:12px; padding:30px; margin-top:20px;">
        <h2 style="margin-top:0;">Send a Message</h2>

        @if(session('success'))
            <div style="background:#16a34a; color:#000; padding:15px; border-radius:8px; margin-bottom:20px; font-weight:700;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('page.contact.send') }}">
            @csrf
            <div style="margin-bottom:15px;">
                <label style="display:block; font-size:0.85rem; font-weight:700; margin-bottom:6px; color:#94a3b8;">Your Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    style="width:100%; background:#020617; border:1px solid #374151; color:#f8fafc; padding:10px 14px; border-radius:8px; font-size:0.95rem;">
                @error('name')<span style="color:#dc2626; font-size:0.8rem;">{{ $message }}</span>@enderror
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; font-size:0.85rem; font-weight:700; margin-bottom:6px; color:#94a3b8;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    style="width:100%; background:#020617; border:1px solid #374151; color:#f8fafc; padding:10px 14px; border-radius:8px; font-size:0.95rem;">
                @error('email')<span style="color:#dc2626; font-size:0.8rem;">{{ $message }}</span>@enderror
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; font-size:0.85rem; font-weight:700; margin-bottom:6px; color:#94a3b8;">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                    style="width:100%; background:#020617; border:1px solid #374151; color:#f8fafc; padding:10px 14px; border-radius:8px; font-size:0.95rem;">
                @error('subject')<span style="color:#dc2626; font-size:0.8rem;">{{ $message }}</span>@enderror
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:0.85rem; font-weight:700; margin-bottom:6px; color:#94a3b8;">Message</label>
                <textarea name="message" rows="5" required
                    style="width:100%; background:#020617; border:1px solid #374151; color:#f8fafc; padding:10px 14px; border-radius:8px; font-size:0.95rem; resize:vertical;">{{ old('message') }}</textarea>
                @error('message')<span style="color:#dc2626; font-size:0.8rem;">{{ $message }}</span>@enderror
            </div>
            <button type="submit"
                style="background:#16a34a; color:#000; border:none; padding:12px 30px; border-radius:8px; font-weight:900; font-size:1rem; cursor:pointer;">
                Send Message
            </button>
        </form>
    </div>

    <div style="margin-top:30px;">
        <h2>Other Ways to Reach Us</h2>
        <p>You can also reach us through the Funny Bingo community. We typically respond within 1–2 business days.</p>
        <p>For bug reports or feature requests, please describe your issue in detail including your browser and device type.</p>
    </div>
</div>
@endsection

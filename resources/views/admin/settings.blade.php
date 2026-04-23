@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<div class="page-header">
    <h1>Settings</h1>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')

    {{-- Google Analytics --}}
    <div class="card" style="margin-bottom: 24px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="width:36px; height:36px; background:#e37400; border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.85rem; color:#fff; flex-shrink:0;">GA</div>
            <div>
                <div style="font-weight:800; font-size:1rem;">Google Analytics (GA4)</div>
                <div style="font-size:0.78rem; color:#64748b;">Tracks visitors across all public pages and the admin panel.</div>
            </div>
            <div style="margin-left:auto;">
                @if($ga_id && $ga_id !== 'G-XXXXXXXXXX')
                    <span style="background:#14532d; color:#86efac; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;">● ACTIVE</span>
                @else
                    <span style="background:#1e293b; color:#64748b; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;">○ NOT SET</span>
                @endif
            </div>
        </div>

        <div class="form-group" style="max-width:400px;">
            <label for="google_analytics_id">Measurement ID</label>
            <input type="text" id="google_analytics_id" name="google_analytics_id"
                   value="{{ old('google_analytics_id', $ga_id === 'G-XXXXXXXXXX' ? '' : $ga_id) }}"
                   placeholder="G-XXXXXXXXXX">
            <span class="field-hint">Found in Google Analytics → Admin → Data Streams → your stream.</span>
            @error('google_analytics_id')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div style="margin-top:16px; padding:14px; background:#0f172a; border-radius:8px; border:1px solid #1e293b;">
            <p style="font-size:0.78rem; color:#64748b; margin:0 0 8px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;">How to get your Measurement ID</p>
            <ol style="font-size:0.8rem; color:#94a3b8; padding-left:18px; line-height:1.8; margin:0;">
                <li>Go to <strong style="color:#f1f5f9;">analytics.google.com</strong></li>
                <li>Click <strong style="color:#f1f5f9;">Admin</strong> (gear icon, bottom-left)</li>
                <li>Under Property, click <strong style="color:#f1f5f9;">Data Streams</strong></li>
                <li>Click your web stream → copy the <strong style="color:#fbbf24;">Measurement ID</strong> (G-XXXXXXXXXX)</li>
            </ol>
        </div>

        @if($ga_id && $ga_id !== 'G-XXXXXXXXXX')
        <div style="margin-top:14px; padding:12px 14px; background:#0f172a; border-radius:8px; border:1px solid #1e293b; font-size:0.8rem; color:#64748b;">
            <strong style="color:#86efac;">Active ID:</strong>
            <code style="color:#fbbf24; margin-left:6px;">{{ $ga_id }}</code>
            &nbsp;·&nbsp;
            <a href="https://analytics.google.com" target="_blank" style="color:#2563eb;">Open Analytics →</a>
        </div>
        @endif
    </div>

    {{-- Google Search Console --}}
    <div class="card" style="margin-bottom: 24px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="width:36px; height:36px; background:#34a853; border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.75rem; color:#fff; flex-shrink:0;">GSC</div>
            <div>
                <div style="font-weight:800; font-size:1rem;">Google Search Console</div>
                <div style="font-size:0.78rem; color:#64748b;">Verify site ownership so Google can index and report your pages.</div>
            </div>
            <div style="margin-left:auto;">
                @if($gsc_verification)
                    <span style="background:#14532d; color:#86efac; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;">● VERIFIED</span>
                @else
                    <span style="background:#1e293b; color:#64748b; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;">○ NOT SET</span>
                @endif
            </div>
        </div>

        <div class="form-group" style="max-width:500px;">
            <label for="gsc_verification">Verification Token</label>
            <input type="text" id="gsc_verification" name="gsc_verification"
                   value="{{ old('gsc_verification', $gsc_verification) }}"
                   placeholder="abc123XYZ...">
            <span class="field-hint">From Search Console → Settings → Ownership verification → HTML tag → content="<strong>paste only this part</strong>".</span>
            @error('gsc_verification')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div style="margin-top:16px; padding:14px; background:#0f172a; border-radius:8px; border:1px solid #1e293b;">
            <p style="font-size:0.78rem; color:#64748b; margin:0 0 8px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;">How to get your verification token</p>
            <ol style="font-size:0.8rem; color:#94a3b8; padding-left:18px; line-height:1.8; margin:0;">
                <li>Go to <strong style="color:#f1f5f9;">search.google.com/search-console</strong> and add your property</li>
                <li>Choose <strong style="color:#f1f5f9;">HTML tag</strong> verification method</li>
                <li>Copy only the token inside <code style="color:#fbbf24;">content="..."</code> — not the full tag</li>
                <li>Paste it above and save, then click <strong style="color:#f1f5f9;">Verify</strong> in Search Console</li>
            </ol>
        </div>

        @if($gsc_verification)
        <div style="margin-top:14px; padding:12px 14px; background:#0f172a; border-radius:8px; border:1px solid #1e293b; font-size:0.8rem; color:#64748b;">
            <strong style="color:#86efac;">Active token:</strong>
            <code style="color:#fbbf24; margin-left:6px; word-break:break-all;">{{ $gsc_verification }}</code>
            &nbsp;·&nbsp;
            <a href="https://search.google.com/search-console" target="_blank" style="color:#2563eb;">Open Search Console →</a>
        </div>
        @endif
    </div>

    {{-- AdSense --}}
    <div class="card" style="margin-bottom: 24px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="width:36px; height:36px; background:#4285f4; border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:0.75rem; color:#fff; flex-shrink:0;">ADS</div>
            <div>
                <div style="font-weight:800; font-size:1rem;">Google AdSense</div>
                <div style="font-size:0.78rem; color:#64748b;">Displays ads on blog posts, the homepage, and content pages.</div>
            </div>
            <div style="margin-left:auto;">
                @if($adsense_client)
                    <span style="background:#14532d; color:#86efac; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;">● ACTIVE</span>
                @else
                    <span style="background:#1e293b; color:#64748b; padding:3px 10px; border-radius:20px; font-size:0.75rem; font-weight:700;">○ NOT SET</span>
                @endif
            </div>
        </div>

        <div class="form-group" style="max-width:400px;">
            <label for="adsense_client">Publisher ID</label>
            <input type="text" id="adsense_client" name="adsense_client"
                   value="{{ old('adsense_client', $adsense_client) }}"
                   placeholder="ca-pub-0000000000000000">
            <span class="field-hint">Found in AdSense → Account → Account information.</span>
            @error('adsense_client')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div style="margin-top:16px; padding:14px; background:#0f172a; border-radius:8px; border:1px solid #1e293b;">
            <p style="font-size:0.78rem; color:#64748b; margin:0 0 8px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;">Where ads appear on your site</p>
            <ul style="font-size:0.8rem; color:#94a3b8; padding-left:18px; line-height:1.8; margin:0;">
                <li>Banner at top of all content pages (Blog, About, Contact, etc.)</li>
                <li>Above and below each blog post body</li>
                <li>Auto ads on the Bingo game page</li>
                <li>Mobile host page</li>
            </ul>
            <p style="font-size:0.75rem; color:#475569; margin:10px 0 0;">Ads do <strong>not</strong> appear on the admin panel.</p>
        </div>

        @if($adsense_client)
        <div style="margin-top:14px; padding:12px 14px; background:#0f172a; border-radius:8px; border:1px solid #1e293b; font-size:0.8rem; color:#64748b;">
            <strong style="color:#86efac;">Active Publisher ID:</strong>
            <code style="color:#fbbf24; margin-left:6px;">{{ $adsense_client }}</code>
            &nbsp;·&nbsp;
            <a href="https://adsense.google.com" target="_blank" style="color:#2563eb;">Open AdSense →</a>
        </div>
        @endif
    </div>

    {{-- Admin password --}}
    <div class="card" style="margin-bottom: 24px;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="width:36px; height:36px; background:#7c3aed; border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:1rem; color:#fff; flex-shrink:0;">🔑</div>
            <div>
                <div style="font-weight:800; font-size:1rem;">Admin Password</div>
                <div style="font-size:0.78rem; color:#64748b;">Change your admin login password.</div>
            </div>
        </div>

        <div class="form-group" style="max-width:400px;">
            <label for="admin_password">New Password</label>
            <input type="text" id="admin_password" name="admin_password"
                   value="{{ old('admin_password', $admin_password) }}"
                   minlength="8" required>
            <span class="field-hint">Minimum 8 characters. Stored in your .env file.</span>
            @error('admin_password')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save Settings</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
</form>
@endsection

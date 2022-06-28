<div class="visible-print text-center">
    <img
        src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(1000)->merge('/logo.png')->generate(route('redirect.to.appstore'))) }}">
</div>

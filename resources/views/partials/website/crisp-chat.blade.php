@php
  $crispWebsiteId = trim((string) config('services.crisp.website_id'));
@endphp

@if($crispWebsiteId !== '')
  <script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = @json($crispWebsiteId);
    (function () {
      var d = document;
      var s = d.createElement('script');
      s.src = 'https://client.crisp.chat/l.js';
      s.async = 1;
      d.getElementsByTagName('head')[0].appendChild(s);
    })();
  </script>
@endif

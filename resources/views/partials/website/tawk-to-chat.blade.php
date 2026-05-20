@php
  $tawkPropertyId = trim((string) config('services.tawk_to.property_id'));
  $tawkWidgetId = trim((string) config('services.tawk_to.widget_id', 'default')) ?: 'default';
@endphp

@if($tawkPropertyId !== '')
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {};
    var Tawk_LoadStart;
    (function () {
      var loaded = false;
      var loadTawk = function () {
        if (loaded) {
          return;
        }

        loaded = true;
        Tawk_LoadStart = new Date();
        
      var s1 = document.createElement('script');
      var s0 = document.getElementsByTagName('script')[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/{{ $tawkPropertyId }}/{{ $tawkWidgetId }}';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
      };

      window.addEventListener('load', function () {
        window.setTimeout(loadTawk, 4500);
      }, { once: true });
      ['click', 'keydown', 'touchstart', 'mousemove'].forEach(function (eventName) {
        window.addEventListener(eventName, loadTawk, { once: true, passive: true });
      });
    })();
  </script>
@endif

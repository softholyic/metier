@php
$openingService = new App\Services\OpeningService;
$companyService = new App\Services\CompanyService;
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'public_location' => asset("/"),
    'githubAuth' => config('services.github.client_id'),

    'salary_ranges'=> $openingService->salary_ranges,
    'employee_counts' => $companyService->employee_counts,

    'work_experiences'=> [
      "No Experience",
      "Less or 1 yr. Experience",
      "2 to 4 yrs.",
      "5+ yrs."
      ],

      'programming_languages' => \App\ProgrammingLanguage::all(),
      'technologies' => \App\Technology::all(),
      'provinces' => \DB::table('provinces')->get(),
      'author' => 'Gart',
];

$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>
  <meta name="auth_id" content="{{Auth::check() ?? Auth::user()->id}}">
  <link rel="shortcut icon" href="{{asset('images/logo.ico')}}" type="image/x-icon" />
  
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
  <div id="app"></div>

  <!-- Load Facebook SDK for JavaScript -->
  <!-- <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script> -->

  <!-- Your customer chat code -->
  <!-- <div class="fb-customerchat"
    attribution=setup_tool
    page_id="1616078145371975"
    theme_color="#ffc300">
  </div> -->
  <!--  -->
  {{-- Global configuration object --}}
  <script>window.config = @json($config);</script>

  {{-- Polyfill JS features via polyfill.io --}}
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

  {{-- Load the application scripts --}}
  @if (app()->isLocal())
    <script src="{{ mix('js/app.js') }}"></script>
  @else
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://unpkg.com/vue-ckeditor2"></script>
  @endif
  <script>
  function panelManager(target){
    this.showPanel = function(panel){
      this.hideAll();
      jQuery(panel).show();
    },
    this.hideAll = function(){
      jQuery(target).find('.panel').hide();
    }
  }
  function getParameterByName(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, '\\$&');
      var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
          results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }
  function getSkills(skill, id){
    for(var i = 0; i < window.config[skill].length; i++){
      if(window.config[skill][i].id == id){
        return window.config[skill][i]
      }
    }
  }
  </script>
</body>
</html>

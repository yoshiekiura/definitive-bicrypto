@component('mail::message')
@component('mail::panel', ['status' => $status])

{{-- Content  --}}
<center>
	<h1 class="center">{!! replace_shortcode(replace_with($greeting, '[[user_name]]', $template->name)) !!}</h1>
	<img style="width:88px; margin-bottom:10px;" src="https://lh3.googleusercontent.com/izhCOpQ5GAS6PZFbofpIyiBQtsPnq3BDZhQGBZ12NsPiWEsA98SzbSmqtjW9eYEr5-aNwPXqhVUcdN3q5iFEW_G9LQek5si9l1TQx55gUACFk6u3myGjUbfXpeTOO9hWCezaw3HbebcSK9NAHiL-eUkJkONfcJvcSKjzAd1CbfRdWRQgvu6moISDIO0FfxXnUnKD19sYK97XgVOE_UXnUiptAemh7YPRvnwFtYx_LXozqI8J7FpOQnETo0Co-CeQTYajzQYWWCc1jHDXl_kL5jtKz6tM46f636Fz_dZ0kSg9Iur2Fmbw-Evj6YNPPAGJXdZS8SVEIDHXRylev6myC0eLXvO6uo5w1x5RY7pMHTcC8wWQfM2MI-zYBUOohtjuNjR5u6M6a2RotPAMDlGVzRouuhoLOhUxugwERpiCuYALaAFXt0IuOLpT-TsljSCPfO1C-bGMY-X3os5ejlxxWF9DB429KglINtmLfSvbRO96JOjmiw4QdwNotrq5gbdMFBc2RBARALKT1f0rYatU7t-PvmgWQn2bKAbYD-nL-r1P2avpTX0ZaaHW2zfMZyIQyoffhw0DyY330mWPiOoIbyAUD3tuzwG-NSWKwZYLtYZJ47EI79ItJRoJQZi9vJHh-xTKTuTAA4sZypVqQpXExk_pVoh0F1WgJS8G-10hUgqunJWL0agVmLG-CrPPD_oJh3M6GO9btWBc9Ji3b6ojEfSU=s176-no?authuser=0" alt="img">
	<h2 class="center" style="font-size: 18px; color: #16a1fd; font-weight: 400; margin-bottom: 8px;">{{ replace_shortcode(replace_with($template->subject, '[[user_name]]', $template->name)) }}</h2>
	<p class="center">{!! str_replace("\n", "<br>",replace_shortcode($template->message)) !!}</p>
</center>
@endcomponent

@endcomponent

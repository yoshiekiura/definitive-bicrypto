@component('mail::message')

@component('mail::panel', ['status' => $status])
{{-- Content  --}}
<center>
	<h1 class="center">{!! replace_shortcode(replace_with($greeting, '[[user_name]]', $template->name)) !!}</h1>
	<img style="width:88px; margin-bottom:10px;" src="https://lh3.googleusercontent.com/sFgguxP8dw5PbH37gy9mjcrY2rvn1Fmp1Jtz4EtV5xdetRb6xoj0GooUtr0peCrZGtKE0PsDCQNNRhDCIIKDiI8eB-xx3d4nGvhS3_epoIOegDHhuKLOaavMFxigu5vOYnKkDX-2dws7f6djIRO6ReeI-K1Mx0JEd2bgUwy-888weCjElAQ6fhsHaHy12gbpUMQqJjxM3Gr5QSQDu-i8fYKle9VKozG3BX0jg9Fzlpwhxe77enxWxwp7VGOLqz1C-nPao_Bnptghkdv196qEvU85N1urUDW_ZQ1iy0-Q0lOmxafxxwLZdeg7d3RHE0wWIT-8pd7e8fIF17H9L38lpt1rMQbm96pVc6T2l6FomKTVHPrOoJmsDIRYh6ZtI-pQe7q7WRLy4OHogWaHOiZl12i2VFN3AeljjQhqbBh_pT2Q05j5Rria6U9RcLWPUPdGdd8mb0F9HmOa9v2Y_Ng0kSF6jbANblfNRva4m4ViO7qVuQ1LXShE9fhqSoBQDJrU1O8aMSeMOaCAA32xnWLoaT6cbP-GW6ACsUAVH49xAm0bZ1krYpP3UMcStCmmZrjvoK5VddxbcAFMoQMsc3r1WoIHmoSGmMk3VWeQNulz1jRDm-tSSewS45pOKKZJkW-gXdKuf2A7B7KUjNFuh9Ka8PE1opQm1qx7NhQX0_-VqSMr7nkm7DPTehPWqzxyDQaADo4_2-96aoDKK3e5cU53DnKx=s176-no?authuser=0" alt="img">
	<h2 class="center" style="font-size: 18px; color: #ffc100; font-weight: 400; margin-bottom: 8px;">{!! replace_shortcode(replace_with($template->subject, '[[user_name]]', $template->name)) !!} </h2>
	<p class="center">{!! str_replace("\n", "<br>",replace_shortcode($template->message)) !!} </p>
</center>
@endcomponent

@endcomponent

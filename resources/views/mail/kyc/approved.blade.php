@component('mail::message')

	@component('mail::panel', ['status' => $status])
		{{-- Content  --}}
		<center>
			<h1 class="center">{!! replace_shortcode(replace_with($greeting, '[[user_name]]', $template->name)) !!}</h1>
            <img style="width:88px; margin-bottom:10px;" src="https://lh3.googleusercontent.com/taPjB1TArAbHnFRCWynJBLJ5zKZYqMosF3PseoT2exLH2tQF76lfG4fd_TZSCEveK5jcnk1I-gnfbBsDfpYUJHVZZWxnpbsjXm9ShpC2UgVTj7oxttyNafk1CGmF26BJP37HsqlUSisOOC5B2Xrff1k2mZT0TNnCi7r8Xq3-_XZwmAr-4dCZJGtv4dPIMIx3igQF4nmQzj0ONUnVhDqSqwJXbeamYChp_-zvkyYbt-VHDBgyOtWMkZ0yLehrupHG7L-F3C3u-JvTqPnAE9aR4edjsLpnzm49dsfAD-Ipu5Tkw2KW4uChNyZ_S8ikBgcNVLHvYxjx89j1rI3mbiqFGzp3J1v2xvqpaQBx24ZI7anvBU3nVRoeEjhykI8LncU_GWQ4d9vhaz5psC5M8On3TAB4SAy2jVhhEGD3RRN_odiG2lenoCF87wWE684CTAKlOnars-mtLilnwhtTz-P6lvJlyRhu-wx3IB9cDMRInJz-x-S9U3BN45ThVG8FeSU6rVKgYm2VxSTdwJJAMzYDChhQZzDSNr9B5i8UZ4HgLIXDeICu_zQxcbhLOI78H_ncmTribYSCgmw48mcKVctNI5lxznxcIzDQmOFg95NkBETLcSSe1X0xmE3wsqlTpRxu2rT9AcNWbDHELqpmjTUMFd4WcbEXo5PmEtSZLkctgIxhxZGCf0of0dKeZJ7bKveiZeZbC169Aue1H0vEBN7I6J6T=s176-no?authuser=0" alt="img">
            <h2 class="center" style="font-size: 18px; color: #00d285; font-weight: 400; margin-bottom: 8px;">{{ replace_shortcode(replace_with($template->subject, '[[user_name]]', $template->name)) }}</h2>
            <p class="center">{!! str_replace("\n", "<br>",replace_shortcode($template->message)) !!}</p>
		</center>
	@endcomponent

@endcomponent

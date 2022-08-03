@component('mail::message')

@component('mail::panel', ['status' => $status])

{{-- Content  --}}
<center>
	<h1 class="center">{!! replace_shortcode(replace_with($greeting, '[[user_name]]', $template->name)) !!}</h1>
	<img style="width:88px; margin-bottom:10px;" src="https://lh3.googleusercontent.com/U8qDnEJ2LcBun3qR1zk8bVkJsAfuhBtWzsI2pFmono6hu74tqJHw51_xQjdlozMNhOPr2z-jmMSgA2UwgZCdZMrUKizWA1JmGoH7GYQKyFmQH8XgAMgrL657stpEzpgH0d0xdebRvP3Bj3UgALarYl3JyOP1cTbw1WLK2_MFnR6OY6nbulkJTUz1zinFxmNZtEO9KGfHF7ppqEez2djtVFAVhnNMCpRZ-s0KGQ0MX1u10pOO8bbpXBE3fNPgnFmPu56UIGUqqCADPbesN5AXI8GrrHEAA3kcSYd4GDns_t_dNIkKT0KAUsNNWBPJDCxoYWqnGOzbx74nzbN4aU57FIf-jHl_Exd7qvjA5izE8fOB_1M3g4ml7WFLO8KNIW5vsbYpSBG4fPZ-H8u1QlZtsynayisqdjIvkxAeN3FBY4G_bJe2RH8OAkMiLL8HS-yC5AxwKsrFbXpiBlByhLEfBfXqpimCT2KEZlpjhs7k4F7A-N7OAOIEjrDw38QIgNwxNtpPxfyN7f2uezbOnMUyGRuqh8yQb7P5MZGVjDz7hPtdZUOkWfsowux77GCFQuIAvWaV5QEbthpu7gwoh46VM58Ikdae5c5cleLxDGxrSwtJZgDU-gV192agGD_n1ex24Sm7gZC9SqjfuYy01gmMHQWmcdeYYDV0xc8ldTMMY2IR7tu-rhdzzlFPMQuXJf7E8oTYKxGBVvObQNXusYVS1WVj=s176-no?authuser=0" alt="img">
	<h2 class="center" style="font-size: 18px; color: #ff3649; font-weight: 400; margin-bottom: 8px;">{{ replace_shortcode(replace_with($template->subject, '[[user_name]]', $template->name)) }}</h2>
	<p class="center">{!! str_replace("\n", "<br>",replace_shortcode($template->message)) !!}</p>
</center>
@endcomponent


@endcomponent

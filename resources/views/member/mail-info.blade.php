<p>Member info </p>
<p>Reference number: {{ $data->reference }}</p>
<hr>
<p>{{ $data->title }} {{ $data->first_name }}@if ($data->middle_name != null && $data->middle_name != '')
        {{ $data->middle_name }}
    @endif {{ $data->last_name }}</p>
<p>{{ $data->country }}, {{ $data->organization }}</p>
<hr>
<p>Please proceed to the website <a href="https://www.pics2023bkk.com"><u><i>Cick here</i></u></a> </p>
<p>This login information is unique for individuals, please use Member login for the purpose of access to 2023 PIC/S
    Committee meeting and Seminar materials.</p>
<p>Username: {{ $data->email }}</p>
<p>Password: {{ $data->password_raw }}</p>
<br>
<p>The payment receipt from FOOD AND DRUG ADMINISTRATION FOUNDATION will be available for download when you logged in.
</p>
<br>
<p>For certain countries that may need a visa to enter the Kingdom of Thailand please use our service in “Member login”
    and kindly provide travel document information for the visa assistant letter.</p>
<br>
<p>Thank you and we are looking forward to seeing you in 2023 PIC/S event in Bangkok, Thailand.</p>
<br>
<p>Food and Drug Administration, Ministry of Public Health, Thailand (Thai FDA)
    88/24 Tiwanon Road, Nonthaburi, Thailand 11000
</p>
<p>T:<a href="tel:+6625907704"> +(66) 2590 7704</a></p>
<p>Email:<a href="mailto:druginspection@fda.moph.go.th"> druginspection@fda.moph.go.th</a></p>
<a href="https://www.pics2023bkk.com">www.pics2023bkk.com</a>

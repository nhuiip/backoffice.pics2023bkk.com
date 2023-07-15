<p>Payment Reminder</p>
<p>(Please ignore this email, if you have paid and the transaction is under process)</p>
<p>Reference number: {{ $data->reference }}</p>
<p>Please review the following details;</p>
<hr>
<p>{{ $data->title }} {{ $data->first_name }}@if ($data->middle_name != null && $data->middle_name != '')
        {{ $data->middle_name }}
    @endif {{ $data->last_name }}</p>
<p>{{ $data->country }}, {{ $data->organization }}</p>
<hr>
<p>If the condition and registration fee are confirmed, please proceed to the payment. </p>
<p>Payment should be made within 15 days of this registration.</p>
<p>ONLINE PAYMENT GATEWAY: <a href="https://pics2023bkk.com/register/{{ $data->reference }}"><i><u>Cick here</u></i></a>
</p>
<br>
<p>Or by bank transfer (charges to be borne by payer) in favour of:</p>
<p>Account Name: FOOD AND DRUG ADMINISTRATION FOUNDATION FOR PIC/S 2023</p>
<p>Account No: 142-0-32966-9</p>
<p>Bank: KRUNG THAI BANK PUBLIC COMPANY LIMITED</p>
<p>SWIFT Code: KRTHTHBK</p>
<p>Address: BANGKOK, THAILAND</p>
<p>Branch: Ministry of Public Health Tiwanon Branch (Branch Code 142) 88/20 1st Floor Block E Ministry of Public Health
    Moo 4 Soi Bamrat Naradul, Tiwanon Road, Talat Khwan, Mueang Nonthaburi, Nonthaburi, 11000, THAILAND
</p>
<p>Account No: 142-0-32966-9</p>
<br>
<p>When your payment is completed, you will receive an email confirmation for further process. </p>
<br>
<p>Food and Drug Administration, Ministry of Public Health, Thailand (Thai FDA)
    88/24 Tiwanon Road, Nonthaburi, Thailand 11000
</p>
<p>T:<a href="tel:+6625907704"> +(66) 2590 7704</a></p>
<p>Email:<a href="mailto:druginspection@fda.moph.go.th"> druginspection@fda.moph.go.th</a></p>
<a href="https://www.pics2023bkk.com">www.pics2023bkk.com</a>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Transaction Id</th>
            <th>Reference</th>
            <th>Email</th>
            <th>Email Secondary</th>
            <th>Title</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>City Code</th>
            <th>City / State / District</th>
            <th>Country</th>
            <th>Phone</th>
            <th>Mobile Phone</th>
            <th>Authority / Organisation</th>
            <th>Professional Title</th>
            <th>Registration group</th>
            <th>Registration type</th>
            <th>Tax Id</th>
            <th>Tax Phone</th>
            <th>Dietary Restrictions</th>
            <th>Special Requirements</th>
            <th>Total</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Nationality</th>
            <th>Gender</th>
            <th>Identification Number</th>
            <th>Passport Number</th>
            <th>Passport Issue Date</th>
            <th>Passport Expiry Date</th>
            <th>Date Of Birth</th>
            <th>Place Of Birth</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->transaction_id }}</td>
                <td>{{ $item->reference }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->email_secondary }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->first_name }}</td>
                <td>{{ $item->middle_name }}</td>
                <td>{{ $item->last_name }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->city_code }}</td>
                <td>{{ $item->city }}</td>
                <td>{{ $item->country }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->phone_mobile }}</td>
                <td>{{ $item->organization }}</td>
                <td>{{ $item->profession_title }}</td>
                <td>{{ $item->registrant_group }}</td>
                <td>{{ $item->registration_type }}</td>
                <td>{{ $item->tax_id }}</td>
                <td>{{ $item->tax_phone }}</td>
                <td>{{ $item->dietary_restrictions }}</td>
                <td>{{ $item->special_requirements }}</td>
                <td>{{ $item->total }}</td>
                <td>
                    @switch($item->payment_method)
                        @case(1)
                            Credit Card
                        @break

                        @case(2)
                            Bank Transfer
                        @break
                    @endswitch
                </td>
                <td>
                    @switch($item->payment_status)
                        @case(1)
                            Pending
                        @break

                        @case(2)
                            Paid
                        @break
                    @endswitch
                </td>
                @if (count($item->members_visas) != 0)
                    <td>{{ $item->members_visas[0]->nationality }}</td>
                    <td>{{ $item->members_visas[0]->gender }}</td>
                    <td>{{ $item->members_visas[0]->identification_number }}</td>
                    <td>{{ $item->members_visas[0]->passport_number }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->members_visas[0]->passport_issue_date)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->members_visas[0]->passport_expiry_date)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->members_visas[0]->date_of_birth)) }}</td>
                    <td>{{ $item->members_visas[0]->place_of_birth }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->members_visas[0]->start_date)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->members_visas[0]->end_date)) }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

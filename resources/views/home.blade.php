@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="media static-widget m-0">
                        <div class="media-body">
                            <h4 class="font-roboto">Registrant (All)</h4>
                            <h1 class="mb-0 counter">{{ $count_member_all }}</h1>
                        </div>
                        <svg class="fill-danger" width="41" height="46" viewBox="0 0 41 46"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.5245 23.3155C24.0019 23.3152 26.3325 16.8296 26.9426 11.5022C27.6941 4.93936 24.5906 0 17.5245 0C10.4593 0 7.35423 4.93899 8.10639 11.5022C8.71709 16.8296 11.047 23.316 17.5245 23.3155Z">
                            </path>
                            <path
                                d="M31.6878 26.0152C31.8962 26.0152 32.1033 26.0214 32.309 26.0328C32.0007 25.5931 31.6439 25.2053 31.2264 24.8935C29.9817 23.9646 28.3698 23.6598 26.9448 23.0998C26.2511 22.8273 25.6299 22.5567 25.0468 22.2485C23.0787 24.4068 20.5123 25.5359 17.5236 25.5362C14.536 25.5362 11.9697 24.4071 10.0019 22.2485C9.41877 22.5568 8.79747 22.8273 8.10393 23.0998C6.67891 23.6599 5.06703 23.9646 3.82233 24.8935C1.6698 26.5001 1.11351 30.1144 0.676438 32.5797C0.315729 34.6148 0.0734026 36.6917 0.00267388 38.7588C-0.0521202 40.36 0.738448 40.5846 2.07801 41.0679C3.75528 41.6728 5.48712 42.1219 7.23061 42.4901C10.5977 43.2011 14.0684 43.7475 17.5242 43.7719C19.1987 43.76 20.8766 43.6249 22.5446 43.4087C21.3095 41.6193 20.5852 39.4517 20.5852 37.1179C20.5853 30.9957 25.5658 26.0152 31.6878 26.0152Z">
                            </path>
                            <path
                                d="M31.6878 28.2357C26.7825 28.2357 22.8057 32.2126 22.8057 37.1179C22.8057 42.0232 26.7824 46 31.6878 46C36.5932 46 40.57 42.0232 40.57 37.1179C40.57 32.2125 36.5931 28.2357 31.6878 28.2357ZM35.5738 38.6417H33.2118V41.0037C33.2118 41.8453 32.5295 42.5277 31.6879 42.5277C30.8462 42.5277 30.1639 41.8453 30.1639 41.0037V38.6417H27.802C26.9603 38.6417 26.278 37.9595 26.278 37.1177C26.278 36.276 26.9602 35.5937 27.802 35.5937H30.1639V33.2318C30.1639 32.3901 30.8462 31.7078 31.6879 31.7078C32.5296 31.7078 33.2118 32.3901 33.2118 33.2318V35.5937H35.5738C36.4155 35.5937 37.0978 36.276 37.0978 37.1177C37.0977 37.9595 36.4155 38.6417 35.5738 38.6417Z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="media static-widget m-0">
                        <div class="media-body">
                            <h4 class="font-roboto">Registrant (Paid)</h4>
                            <h1 class="mb-0 counter">{{ $count_member_paid }}</h1>
                        </div>
                        <svg class="fill-success" width="41" height="46" viewBox="0 0 41 46"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.5245 23.3155C24.0019 23.3152 26.3325 16.8296 26.9426 11.5022C27.6941 4.93936 24.5906 0 17.5245 0C10.4593 0 7.35423 4.93899 8.10639 11.5022C8.71709 16.8296 11.047 23.316 17.5245 23.3155Z">
                            </path>
                            <path
                                d="M31.6878 26.0152C31.8962 26.0152 32.1033 26.0214 32.309 26.0328C32.0007 25.5931 31.6439 25.2053 31.2264 24.8935C29.9817 23.9646 28.3698 23.6598 26.9448 23.0998C26.2511 22.8273 25.6299 22.5567 25.0468 22.2485C23.0787 24.4068 20.5123 25.5359 17.5236 25.5362C14.536 25.5362 11.9697 24.4071 10.0019 22.2485C9.41877 22.5568 8.79747 22.8273 8.10393 23.0998C6.67891 23.6599 5.06703 23.9646 3.82233 24.8935C1.6698 26.5001 1.11351 30.1144 0.676438 32.5797C0.315729 34.6148 0.0734026 36.6917 0.00267388 38.7588C-0.0521202 40.36 0.738448 40.5846 2.07801 41.0679C3.75528 41.6728 5.48712 42.1219 7.23061 42.4901C10.5977 43.2011 14.0684 43.7475 17.5242 43.7719C19.1987 43.76 20.8766 43.6249 22.5446 43.4087C21.3095 41.6193 20.5852 39.4517 20.5852 37.1179C20.5853 30.9957 25.5658 26.0152 31.6878 26.0152Z">
                            </path>
                            <path
                                d="M31.6878 28.2357C26.7825 28.2357 22.8057 32.2126 22.8057 37.1179C22.8057 42.0232 26.7824 46 31.6878 46C36.5932 46 40.57 42.0232 40.57 37.1179C40.57 32.2125 36.5931 28.2357 31.6878 28.2357ZM35.5738 38.6417H33.2118V41.0037C33.2118 41.8453 32.5295 42.5277 31.6879 42.5277C30.8462 42.5277 30.1639 41.8453 30.1639 41.0037V38.6417H27.802C26.9603 38.6417 26.278 37.9595 26.278 37.1177C26.278 36.276 26.9602 35.5937 27.802 35.5937H30.1639V33.2318C30.1639 32.3901 30.8462 31.7078 31.6879 31.7078C32.5296 31.7078 33.2118 32.3901 33.2118 33.2318V35.5937H35.5738C36.4155 35.5937 37.0978 36.276 37.0978 37.1177C37.0977 37.9595 36.4155 38.6417 35.5738 38.6417Z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card o-hidden">
                <div class="card-body">
                    <div class="media static-widget m-0">
                        <div class="media-body">
                            <h4 class="font-roboto">Registrant (Pending)</h4>
                            <h1 class="mb-0 counter">{{ $count_member_pending }}</h1>
                        </div>
                        <svg class="fill-warning" width="41" height="46" viewBox="0 0 41 46"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.5245 23.3155C24.0019 23.3152 26.3325 16.8296 26.9426 11.5022C27.6941 4.93936 24.5906 0 17.5245 0C10.4593 0 7.35423 4.93899 8.10639 11.5022C8.71709 16.8296 11.047 23.316 17.5245 23.3155Z">
                            </path>
                            <path
                                d="M31.6878 26.0152C31.8962 26.0152 32.1033 26.0214 32.309 26.0328C32.0007 25.5931 31.6439 25.2053 31.2264 24.8935C29.9817 23.9646 28.3698 23.6598 26.9448 23.0998C26.2511 22.8273 25.6299 22.5567 25.0468 22.2485C23.0787 24.4068 20.5123 25.5359 17.5236 25.5362C14.536 25.5362 11.9697 24.4071 10.0019 22.2485C9.41877 22.5568 8.79747 22.8273 8.10393 23.0998C6.67891 23.6599 5.06703 23.9646 3.82233 24.8935C1.6698 26.5001 1.11351 30.1144 0.676438 32.5797C0.315729 34.6148 0.0734026 36.6917 0.00267388 38.7588C-0.0521202 40.36 0.738448 40.5846 2.07801 41.0679C3.75528 41.6728 5.48712 42.1219 7.23061 42.4901C10.5977 43.2011 14.0684 43.7475 17.5242 43.7719C19.1987 43.76 20.8766 43.6249 22.5446 43.4087C21.3095 41.6193 20.5852 39.4517 20.5852 37.1179C20.5853 30.9957 25.5658 26.0152 31.6878 26.0152Z">
                            </path>
                            <path
                                d="M31.6878 28.2357C26.7825 28.2357 22.8057 32.2126 22.8057 37.1179C22.8057 42.0232 26.7824 46 31.6878 46C36.5932 46 40.57 42.0232 40.57 37.1179C40.57 32.2125 36.5931 28.2357 31.6878 28.2357ZM35.5738 38.6417H33.2118V41.0037C33.2118 41.8453 32.5295 42.5277 31.6879 42.5277C30.8462 42.5277 30.1639 41.8453 30.1639 41.0037V38.6417H27.802C26.9603 38.6417 26.278 37.9595 26.278 37.1177C26.278 36.276 26.9602 35.5937 27.802 35.5937H30.1639V33.2318C30.1639 32.3901 30.8462 31.7078 31.6879 31.7078C32.5296 31.7078 33.2118 32.3901 33.2118 33.2318V35.5937H35.5738C36.4155 35.5937 37.0978 36.276 37.0978 37.1177C37.0977 37.9595 36.4155 38.6417 35.5738 38.6417Z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @php
            // paid_per_country
            $optionsPaidPerCountry = [];
            $optionsPaidPerCountry['dataCountry'] = [];
            $optionsPaidPerCountry['categoriesCountry'] = [];
            $data = [];
            $categories = [];
            foreach ($paid_per_country as $key => $value) {
                array_push($data, $value->countCountry);
                array_push($categories, $value->country);
            }
            $optionsPaidPerCountry['dataCountry'] = $data;
            $optionsPaidPerCountry['categoriesCountry'] = $categories;
        @endphp
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Paid per country</h5>
                </div>
                <div class="card-body">
                    <div id="paid-per-country-bar" data-data="{{ json_encode($optionsPaidPerCountry['dataCountry']) }}"
                        data-categories="{{ json_encode($optionsPaidPerCountry['categoriesCountry']) }}"></div>
                </div>
            </div>
        </div>
        @php
            // paid_per_organization
            $optionsPaidPerOrganization = [];
            $optionsPaidPerOrganization['data'] = [];
            $optionsPaidPerOrganization['categories'] = [];
            $data = [];
            $categories = [];
            foreach ($paid_per_organization as $key => $value) {
                array_push($data, $value->countOrganization);
                array_push($categories, $value->organization);
            }
            $optionsPaidPerOrganization['data'] = $data;
            $optionsPaidPerOrganization['categories'] = $categories;
        @endphp
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Paid per organization</h5>
                </div>
                <div class="card-body">
                    <div id="paid-per-organization-bar" data-data="{{ json_encode($optionsPaidPerOrganization['data']) }}"
                        data-categories="{{ json_encode($optionsPaidPerOrganization['categories']) }}"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/chart/apex-chart/apex-chart.js') }}"></script>
    <script>
        // basic bar chart
        let dataCountry = JSON.parse($('#paid-per-country-bar').attr('data-data'));
        let categoriesCountry = JSON.parse($('#paid-per-country-bar').attr('data-categories'));
        var optionsPaidPerCountry = {
            chart: {
                height: 300,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                data: dataCountry
            }],
            xaxis: {
                categories: categoriesCountry,
            },
            colors: [zetaAdminConfig.primary]
        }

        var paid_per_country = new ApexCharts(
            document.querySelector("#paid-per-country-bar"),
            optionsPaidPerCountry
        );

        paid_per_country.render();
    </script>
    <script>
        // basic bar chart
        let data = JSON.parse($('#paid-per-organization-bar').attr('data-data'));
        let categories = JSON.parse($('#paid-per-organization-bar').attr('data-categories'));
        var optionsPaidPerOrganization = {
            chart: {
                height: 300,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                data: data
            }],
            xaxis: {
                categories: categories,
            },
            colors: [zetaAdminConfig.primary]
        }

        var paid_per_organization = new ApexCharts(
            document.querySelector("#paid-per-organization-bar"),
            optionsPaidPerOrganization
        );

        paid_per_organization.render();
    </script>
@endsection

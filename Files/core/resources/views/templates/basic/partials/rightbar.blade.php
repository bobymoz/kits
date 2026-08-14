<div class="right-side">
    <div class="container px-lg-1">
        <div class="row g-2 gy-lg-4 justify-content-center">
            <!-- Desk Ads -->
            <div class="col-12 d-none d-lg-block">
                @php echo getAdvertisement('300x250') @endphp
            </div>
            <div class="col-12 d-none d-lg-block">
                @php echo getAdvertisement('540x984') @endphp
            </div>
            <!-- Desk Ads -->
            <!-- Mobile Ads -->
            <div class="col-4 text-center d-lg-none">
                @php echo getAdvertisement('300x250') @endphp
            </div>
            <div class="col-4 text-center d-lg-none">
                @php echo getAdvertisement('300x250') @endphp
            </div>
            <div class="col-4 text-center d-lg-none">
                @php echo getAdvertisement('300x250') @endphp
            </div>
            <!-- Mobile Ads -->
        </div>
    </div>
</div>

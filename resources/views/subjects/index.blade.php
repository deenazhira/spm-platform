@extends('subjects.layouts')
@section('contents')
<body>

<!-- ======= Portfolio Section ======= -->
<section id="work" class="portfolio-mf sect-pt5 route">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="title-box text-center header-space">
                    <h3 class="title-a">SUBJECT SPM</h3>
                    <p class="subtitle-a">List of Subject SPM</p>
                    <div class="line-mf"></div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ([
                ['title' => 'Bahasa Melayu', 'image' => 'assets/img/work-1.jpg'],
                ['title' => 'English', 'image' => 'assets/img/work-2.jpg'],
                ['title' => 'Mathematics', 'image' => 'assets/img/work-3.jpg'],
                ['title' => 'Physics', 'image' => 'assets/img/work-4.jpg'],
                ['title' => 'Chemistry', 'image' => 'assets/img/work-5.jpg'],
                ['title' => 'Biology', 'image' => 'assets/img/work-6.jpg'],
                ['title' => 'Sejarah', 'image' => 'assets/img/work-6.jpg'],
                ['title' => 'Pendidikan Islam', 'image' => 'assets/img/work-6.jpg'],
                ['title' => 'Additional Mathematics', 'image' => 'assets/img/work-6.jpg']
            ] as $subject)
            <div class="col-md-4">
                <div class="work-box">
                    <a href="{{ $subject['image'] }}" data-gallery="portfolioGallery" class="portfolio-lightbox">
                        <div class="work-img">
                            <img src="{{ $subject['image'] }}" alt="" class="img-fluid">
                        </div>
                    </a>
                    <div class="work-content">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2 class="w-title">{{ $subject['title'] }}</h2>
                                <div class="w-more">
                                    <span class="w-ctegory">Web Design</span> / <span class="w-date">18 Sep. 2018</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="w-like">
                                    <a href="portfolio-details.html"><span class="bi bi-plus-circle"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

</body>
@endsection
<!-- End Portfolio Section -->

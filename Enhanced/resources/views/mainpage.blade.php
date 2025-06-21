@extends('master.layout')
@section('content')
<body>

  <!-- ======= HOMEPAGE ======= -->
  <div id="hero" class="hero route bg-image" style="background-image: url(assets/img/counters-bg.jpg)">
    <div class="overlay-itro"></div>
    <div class="hero-content display-table">
      <div class="table-cell">
        <div class="container">
          <h1 class="hero-title mb-4">SPM Learning Platform</h1>
          <p class="hero-subtitle"><span class="typed" data-typed-items="Additional Mathematics, Bahasa Melayu, English, Physics, Chemistry Science, Mathematics, Biology Science"></span></p>
          <p class="pt-3">
            <a class="btn btn-primary btn-custom js-scroll px-4" href="/register" role="button">Register Now</a>
          </p>
        </div>
      </div>
    </div>
  </div><!-- End Hero Section -->
  <style>
    .btn-custom {
      background-color: #cbc0a9; /* Green background */
      border: none; /* Remove borders */
      color: rgb(0, 0, 0); /* White text */
      padding: 14px 28px; /* Some padding */
      font-size: 20px; /* Increase font size */
      cursor: pointer; /* Pointer/hand icon */
      border-radius: 30px; /* Rounded corners */
      transition: all 0.6s ease-in-out; /* Smooth transition */
    }

    .btn-custom:hover {
      background-color: #483521; /* Darker green */
      transform: scale(1.1); /* Slightly larger on hover */
    }

  </style>

<!-- ======= NEWS TRENDY IN MALAYSIA ======= -->
<section id="new" class="new-mf sect-pt4 route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              NEWS TRENDY IN MALAYSIA
            </h3>
            <p class="subtitle-a">
              Stay updated with the latest news.</p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-blog">
            <div class="card-img">
              <a href="new1"><img src="assets/img/news-1.jpg" alt="" class="img-fluid"></a>
            </div>
            <div class="card-body">
              <div class="card-category-box">
                <div class="card-category">
                  <h6 class="category">THE STAR</h6>
                </div>
              </div>
              <h3 class="card-title"><a href="https://www.thestar.com.my/news/nation/2024/06/10/perak-to-help-655-spm-absentees-enrol-in-tvet">Perak to help 655 SPM absentees enrol in TVET</a></h3>
              <p class="card-description animated-description">
                  IPOH: The Perak government will assist 655 students who missed the 2023 Sijil Pelajaran Malaysia (SPM) examinations, ensuring their continuation of studies in the Technical and Vocational Education and Training (TVET) field. State education, higher education, youth and sports committee chairman Khairudin Abu Hanipah said the state Education Department and other relevant parties are currently tasked with locating these students. “The department’s priority is to identify them, considering some may already be pursuing their careers.
              </p>
            </div>
            <div class="card-footer">
              <div class="post-author">
                  <img src="assets/img/thestar.png" alt="" class="avatar rounded-circle">
              </div>
              <div class="post-date">
                <span class="bi bi-clock"></span> 1 hour past
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-blog">
            <div class="card-img">
              <a href="new2"><img src="assets/img/news-2.jpg" alt="" class="img-fluid"></a>
            </div>
            <div class="card-body">
              <div class="card-category-box">
                <div class="card-category">
                  <h6 class="category">MALAY MAIL</h6>
                </div>
              </div>
              <h3 class="card-title"><a href="https://www.malaymail.com/news/malaysia/2024/06/11/works-ministry-plans-to-construct-upgrade-25-schools-in-sarawak-says-deputy-minister/139236"> Works Ministry plans to construct, upgrade 25 schools in Sarawak, says deputy minister </a></h3>
              <p class="card-description animated-description">KUCHING, June 11 — Three out of the 25 schools planned for construction or upgrading in Sarawak are expected to be completed this year. Deputy Minister of Works Datuk Seri Ahmad Maslan stated that these schools are Sekolah Kebangsaan (SK) Jalan Haji Baki and SK Padawan in Kuching, and Sekolah Menengah Kebangsaan Seri Sadong in Simunjan</p>
            </div>
            <div class="card-footer">
              <div class="post-author">
                <a href="#">
                  <img src="assets/img/malaymail.jpg" alt="" class="avatar rounded-circle">
                </a>
              </div>
              <div class="post-date">
                <span class="bi bi-clock"></span>2 days ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-blog">
            <div class="card-img">
              <a href="blog-single.html"><img src="assets/img/news-3.jpg" alt="" class="img-fluid"></a>
            </div>
            <div class="card-body">
              <div class="card-category-box">
                <div class="card-category">
                  <h6 class="category">NEW STRAITS TIMES</h6>
                </div>
              </div>
              <h3 class="card-title"><a href="https://www.nst.com.my/lifestyle/groove/2024/06/1062522/showbiz-educate-restaurant-canteen-staff-about-food-hygiene-anis">#SHOWBIZ: Educate restaurant, canteen staff about food hygiene - Anis Nabilah</a></h3>
              <p class="card-description animated-description">
                  KUALA LUMPUR: Celebrity chef and cookery show host Anis Nabilah Umaruddin, 37, is deeply saddened by the deaths of a teenager and a toddler from suspected food poisoning after eating canteen food recently. She said that schools should educate students and canteen operators about the importance of food hygiene, especially the handling of perishable foods such as eggs."Eggs cannot be washed and subsequently stored in the refrigerator or container. They begin to perish once touched.
              </p>
            </div>
            <div class="card-footer">
              <div class="post-author">
                <a href="#">
                  <img src="assets/img/nst.jpg" alt="" class="avatar rounded-circle">
                </a>
              </div>
              <div class="post-date">
                <span class="bi bi-clock"></span> 10 min
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<style>
.card-description {
    font-size: 1.1em; /* Make the text bigger */
}
.animated-description {
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

.card-blog:hover .animated-description {
    transform: scale(0.90); /* Slightly increase size on hover */
    opacity: 0.9; /* Slightly fade out */
}

.card-category h6.category {
    font-size: 10em; /* Increase font size */
    padding: 10px 20px; /* Increase padding */
}

.subtitle-a {
    font-size: 18px;
    color: #333;
    margin: 10px 0;
    padding: 5px;
    font-weight: lighter;
}


  </style>

    <!-- End Section -->


@endsection

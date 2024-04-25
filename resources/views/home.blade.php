@extends('layouts.base')
@section('content')
    <div class="content-body">
        <!-- Hover Effects -->
        <section id="hover-effects" class="card">
            {{-- <div class="card-header">
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div> --}}
            <div class="card-content">
                <div class="card-body my-gallery">
                    <div class="grid-hover d-flex justify-content-center align-items-center">
                        <div class="">
                            <figure class="effect-lily">
                                <img src="{{ asset('assets/images/gallery/ayam.png') }}" alt="img12" />
                                <figcaption>
                                    <div>
                                        <h2>Ayam <span>Petelur</span></h2>
                                        <p>Jumlah Ayam saat ini: {{ $jumlah_ayam }}</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="">
                            <figure class="effect-lily">
                                <img src="{{ asset('assets/images/gallery/telur.png') }}" alt="img1" />
                                <figcaption>
                                    <div>
                                        <h2>Telur <span>Ayam</span></h2>
                                        <p>Jumlah Telur saat ini: {{ $jumlah_telur }}</p>                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    <div class="card-text text-center">
                        <p>CV. X, penyedia telur berkualitas tinggi dari peternakan ayam petelur kami yang berlokasi di Kabupaten Blitar, Jawa Timur. Kami memiliki dedikasi yang kuat untuk menyediakan produk berkualitas tinggi yang memenuhi standar tertinggi dalam kesejahteraan hewan, kebersihan, dan keamanan pangan.

                            Di CV. X, kami memahami pentingnya menjaga kesejahteraan ayam petelur kami. Oleh karena itu, kami memberikan perhatian khusus terhadap kondisi lingkungan tempat tinggal ayam, asupan pakan yang seimbang, dan perawatan kesehatan yang berkualitas. Dengan pendekatan ini, kami memastikan bahwa setiap telur yang kami hasilkan tidak hanya berkualitas tinggi, tetapi juga diproduksi dengan tanggung jawab yang tinggi terhadap lingkungan dan keberlanjutan.
                            
                            Kami di CV. X bangga dengan inovasi kami dalam teknologi peternakan modern yang membantu kami memonitor dan mengelola produksi kami dengan efisiensi tinggi. Dengan sistem pemantauan yang canggih, kami dapat mengidentifikasi dan mengatasi masalah dengan cepat, sehingga memastikan kualitas produk kami tetap terjaga.</p>
                    </div>
                </div>
            </div>
            
            <!--/ Image grid -->
        </section>
        <!--/ Hover Effects -->

    </div>
@endsection

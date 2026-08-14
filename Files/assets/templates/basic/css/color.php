<?php
header("Content-Type:text/css");
function checkHexColor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}
if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}
if (!$color or !checkHexColor($color)) {
    $color = "#336699";
}
if (isset($_GET['secondColor']) and $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}
if (!$secondColor or !checkHexColor($secondColor)) {
    $secondColor = "#336699";
}


?>

.social-icons li a:hover, .social__icons li a i, .search-form .cmn--btn:hover, .search-form .cmn--btn:hover, .header-top-wrapper li a.header-btn, .sidebar__widget .title::after, .filter-category .sub-category li a::before, .filter-category .sub-category li a:hover::before, .nav--tabs .nav-item .nav-link.active, .dashboard-item .dashboard-icon, .dashboard-item:hover, .cmn--table thead tr th, .post__item .post__thumb .category, .post__share li a i, .widget.widget__tags ul li a:hover, .widget.widget__tags ul li a.active, .post__tag li a:hover, .post__tag li a.active, .post__share li a i, .scrollToTop, .video__button, .video__button::before, .video__button::after, .cmn--btn, .pagination .page-item a.active, .pagination .page-item span.active, .pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a, .dashboard-menu-open {
background: <?php echo $color ?>;
}

.light-version .nav--tabs .nav-item .nav-link.active, .light-version .widget.widget__tags ul li a:hover, .light-version .widget.widget__tags ul li a.active, .light-version .post__tag li a:hover, .light-version .post__tag li a.active, .light-version .bg--body .widget.widget__tags ul li a:hover, .light-version .bg--body .widget.widget__tags ul li a.active, .light-version .bg--body .post__tag li a:hover, .light-version .bg--body .post__tag li a.active, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .custom--card button.form--control {
background: <?php echo $color ?> !important;
}

*::selection, .form--check .form-check-input:checked {
background-color: <?php echo $color ?>;
}

.btn--base, .badge--base, .bg--base, .btn--1, .badge--1, .bg--1 , .payment-card-title{
background-color: <?php echo $color ?> !important;
}


.light-version .contact__item ul li a:hover, .header-links li a:hover, .header-links li a.active, .footer__widget .contact__info .icon, .footer__widget .footer__links li a:hover, .footer__widget .footer__links li a::before, .menu li a:hover, .menu li .submenu li a:hover, .filter-category li a:hover, .filter-category .sub-category li a:hover, .product__details .title-area .btn-side .add-wishlist i, .form--label i, .dashboard-item:hover .dashboard-icon, .contact__item ul li a:hover, .post__item .post__content .meta__date .meta__item i, .post__item .post__read, .widget__post .widget__post__content span, p a, p a:hover,
.cmn--modal .modal-footer .btn-close,
.cmn--modal .modal-header .btn-close {
color: <?php echo $color ?>;
}

.text--base, .text--1 {
color: <?php echo $color ?> !important;
}

.form--check .form-check-input:checked, .dashboard-menu ul li a.active {
border-color: <?php echo $color ?>;
}

.post__item .post__content .meta__date {
border-left: 5px solid <?php echo $color ?>;
}

.post__quote {
border-left: 3px solid <?php echo $color ?>;
}

.dashboard-menu , .header-top-wrapper li a.header-btn{
background: <?php echo $color ?>;
}

.scrollToTop , .cmn--table thead tr th, .dashboard-menu-open {
background: <?php echo $color ?>;
}


.custom--card {
border: 1px dashed <?php echo $color ?>4d;
}

.cmn--btn,.pagination .page-item.active span, .pagination .page-item.active a {
background: <?php echo $color ?>;
}
.payment-item:has(.payment-item__radio:checked) .payment-item__check {
border: 3px solid <?php echo $color ?>;
}
.payment-item__check{
border: 1px solid <?php echo $color ?>;

}

.search-form .cmn--btn:hover, .pagination .page-item:hover span, .pagination .page-item:hover a, .cmn--btn:hover,.header-btn:hover{
background: <?php echo $color ?>9d !important;
}

.select2-container--open .select2-selection.select2-selection--single,
.select2-container--open .select2-selection.select2-selection--multiple, .select2-container--default .select2-search--dropdown .select2-search__field:focus {
border-color: <?php echo $color ?> !important;
}

.payment-item:has(.payment-item__radio:checked) {
border-left: 3px solid <?php echo $color ?> ;
}

/* -----------------------------------------------------------------------------

Soup - Restaurant with Online Ordering System Template

File:           JS Core
Version:        2.00
Last change:    22/05/2020
Author:         Suelo (Piotr Osmola)

-------------------------------------------------------------------------------- */

'use strict'
var myoptions={};
var url = "?data=options";
$.ajax({
  url: url,
  dataType: 'json',
  async: false,
  success: function(data) {
    myoptions = data
  },
  error: function(err) {
    console.log(err);
  }
});
var currenttable='';

if (myoptions.activatetables=="1")
{
  $.ajax({
    url: '?data=tablecode',
    async: false,
    success: function(data) {
      currenttable = data
    },
    error: function(err) {
      console.log(err);
    }
  });
}

var tableCondition =(myoptions.activatetables=="1" && myoptions.enforcetablespreselection=="1" && currenttable!='') ||
                    (myoptions.activatetables=="0") ||
                    (myoptions.activatetables=="1" && myoptions.enforcetablespreselection=="0");
var directactivation =(myoptions.activatelocation=="0") && tableCondition && (myoptions.activateorder=="1");
// Import Third-Part Styles
import 'bootstrap/scss/bootstrap.scss'
import 'slick-carousel/slick/slick.scss'
import 'animsition/dist/css/animsition.css'
import 'animate.css/animate.min.css'
import '@icon/themify-icons/themify-icons.css'
import 'font-awesome/css/font-awesome.css'

// Import Themes
import '../scss/theme-teal.scss'
import '../scss/theme-blue.scss'
import '../scss/theme-green.scss'
import '../scss/theme-mint.scss'
import '../scss/theme-orange.scss'
import '../scss/theme-red.scss'
import '../scss/theme-beige.scss'

import '../scss/rtl.scss'


// Import Modules
import PageTransition from './modules/page-transition'
import BackToTop from './modules/back-to-top'
import Background from './modules/background'
import Carousel from './modules/carousel'
import Cart from './modules/cart'
import Collapse from './modules/collapse'
import Cookies from './modules/cookies'
import Components from './modules/components'
import CustomControl from './modules/custom-control'
import Forms from './modules/forms'
import Navigation from './modules/navigation'
import Modal from './modules/modal'
import Parallax from './modules/parallax'
import Sticky from './modules/sticky'
import Twitter from './modules/twitter'
import Docs from './modules/docs'

import { data } from 'jquery';

// Document - Ready
$(function() {
  Background.init()
  BackToTop.init()
  Carousel.init()
  if (directactivation)
  {
    Cart.init(myoptions,currenttable)
  }
  Collapse.init()
  Cookies.init()
  Components.init()
  CustomControl.init()
  Forms.init()
  Navigation.init()
  Modal.init()
//  PageTransition.init()
  Parallax.init()
  Sticky.init()
  Twitter.init()
  Docs.init()

  if (process.env.PREVIEW) {
    const Styleswitcher = require('./modules/styleswitcher')
    Styleswitcher.default.init()
  }
  if (myoptions.activatelocation=="1"){
    navigator.permissions.query({
       name: 'geolocation'
       }).then(function(result) {
           if (result.state == 'granted') {
               navigator.geolocation.getCurrentPosition(Setlocation);
           } else if (result.state == 'prompt') {
               navigator.geolocation.getCurrentPosition(Setlocation);
           } else if (result.state == 'denied') {
               console.log(result.state);
           }
           result.onchange = function() {
               console.log(result.state);
           }
       });
  }
})

// Document - Click
$(document).on('click', function(e) {
  Navigation.handleClick(e)
  Cart.Panel.handleClick(e)
})

if($('.myImg').length>0)
  {
    $('#myclose').on('click', function(e) {
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    });
    $('.myImg').on('click', function(e) {
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
      var modalImg = document.getElementById("img01");
      var captionText = document.getElementById("caption");
      //modal.style.display = "block";
      modalImg.src = $(this).attr('src');
      captionText.innerHTML = this.alt;
    })

  }

  $(document).on('click','.optionLang ul li', function() {
    window.location = $(".optionLang option[data-value='"+$(this).attr('data-value')+"']").attr('data-link');
});

let scrolled = 0
var allowed =false;

// Window - Scroll
$(window).on('scroll', function() {
  scrolled = $(window).scrollTop()

  BackToTop.handleScroll(scrolled)
  Sticky.handleScroll(scrolled)
})

function Setlocation(loc)
{
  var crd = loc.coords;
  if ((getDistanceFromLatLonInKm(myoptions.lat,myoptions.long,crd.latitude,crd.longitude)<=parseFloat(myoptions.alloweddistance)) && tableCondition)
  {
    Cart.init(myoptions,currenttable)
  }
}

function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1);
  var a =
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ;
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}

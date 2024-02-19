{*
* 2015-2020 Bonpresta
*
* Bonpresta Facebook login
*
* NOTICE OF LICENSE
*
* This source file is subject to the General Public License (GPL 2.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/GPL-2.0
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade the module to newer
* versions in the future.
*
* @author Bonpresta
* @copyright 2015-2020 Bonpresta
* @license http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}
{* facebook login start *}
{* <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script> *}
<script defer>
    var base_dir = '{$mod_dir|escape:"htmlall":"UTF-8"}',
      islogged = '{$islogged|escape:"htmlall":"UTF-8"}';

    function injectFbSdkAsync(d, s, id) {
      var js,
        fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.async = true;
      js.defer = true;

      js.src = 'https://connect.facebook.net/en_US/sdk.js';
      fjs.parentNode.insertBefore(js, fjs);
    }
    $(function () {
      const $facebookButton = $('.bon-facebooklogin-button');
      $facebookButton.on('click', function () {
        injectFbSdkAsync(document, 'script', 'facebooklogin-jssdk');

        window.fbAsyncInit = function () {
          FB.init({
            appId: '{$bon_facebook_app_id|escape:"htmlall":"UTF-8"}',
            autoLogAppEvents: true,
            xfbml: false,
            version: 'v7.0',
            status: true
          });
          siteLoginStatus();
          fblogin();
        };
        function siteLoginStatus() {
          if (islogged > 0) {
            FB.getLoginStatus(function (response) {
              if (response.status === 'connected') {
                var fblogpic = getCookie('fb_user_pic'),
                  fblogcheck = getCookie('fb_user_id');
                if (fblogcheck != undefined && fblogcheck.length > 0) {
                  $('#bon-login-image').html(
                    '<img id="facebook-fb-img" height="31" src="' + fblogpic + '"/>'
                  );
                  $('.user-info .account.bon-tooltip').css('display', 'none');
                  $('.bon-logout').on('click', fblogout);
                  $('.account-bon-logout').on('click', fblogout);
                }
              }
            });
          }
        }
        function fblogin() {
          FB.login(
            function (response) {
              setCookie('fb_user_id', response.authResponse.userID, 1);
              if (response.status == 'connected') {
                login(response.authResponse.accessToken);
              }
            },
            {
              scope: 'email,public_profile,'
            }
          );
          return false;
        }
        function login(token) {
          get_profile_pic();
          $('.bon-facebooklogin-button-loading').show();
          $.ajax({
            type: 'POST',
            url: base_dir + 'bonloginfacebook/controllers/front/facebookconnect.php',
            data: 'accessToken=' + token + '',
            success: function (msg) {
              
              var current_url = window.location.href;
              var queryPos = current_url.lastIndexOf('?');
              queryPos = parseInt(queryPos) + 1;
              current_url = current_url.substr(queryPos);
              queryStrings = current_url.split('&');
              var noBack = 1;
              if (queryStrings.length > 0) {
                var params = queryStrings[0].split('=');
                if (params.length > 0) {
                  if (params[0] == 'back') {
                    var backUrl = decodeURIComponent(params[1]);
                    window.location.href = backUrl;
                    noBack = 0;
                  }
                }
              }
              if (noBack == 1) {
                window.location.href = window.location.href;
              }
            }
          });
        }
        function get_profile_pic() {
          FB.api('/me', function (response) {
            var src = 'https://graph.facebook.com/' + response.id + '/picture';
            setCookie('fb_user_pic', src, 1);
          });
        }
        function fblogout() {
          FB.logout(function (response) {
            deleteCookie('fb_user_id');
            deleteCookie('fb_user_pic');
            logout();
          });
        }
      });
    });

</script>
{* facebook login end *}
<script>
function logout() {
                 window.location.href = '?mylogout';
            }
function setCookie(c_name, value, expires) {
                 document.cookie = c_name + "=" + escape(value);
            }
            function deleteCookie(name) {
                document.cookie = name + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
            }
            function getCookie(name) {
                var i, x, y, ARRcookies = document.cookie.split(";");
                for (i = 0; i < ARRcookies.length; i++) {
                    x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                    y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                    x = x.replace(/^\s+|\s+$/g, "");
                    if (x == name) {
                        return unescape(y);
                    }
                }
            }
</script>

{* google login start *}
 
<script defer>
    function injectGoogleSdkAsync(d, s) {
      var js,
        fjs = d.getElementsByTagName(s)[0];
      js = d.createElement(s);
      js.src = 'https://apis.google.com/js/api.js?onload=onApiLoaded';
      fjs.parentNode.insertBefore(js, fjs);
    }

    setTimeout(() => {
      injectGoogleSdkAsync(document, 'script');
    }, 10000);

    var googleUser = {};

    function onApiLoaded() {
      gapi.load('auth2', function () {
        auth2 = gapi.auth2.init({
          client_id: '{$bon_google_app_id|escape:"htmlall":"UTF-8"}',
          cookiepolicy: 'single_host_origin'
        });
        if (islogged <= 0) {
          attachSignin(document.getElementById('bon-googlelogin-button'));
        }
        setTimeout(googleStatus, 1000);
      });
    }

    function googleStatus() {
      if (auth2.isSignedIn.get() == true && islogged <= 0) {
        var googleImg = getCookie('google_user_pic');
        $('#bon-login-image').html(
          '<img id="google-img" height="31" src="' + googleImg + '"/>'
        );
        $('.user-info .account.bon-tooltip').css('display', 'none');
        $('.bon-logout').on('click', googleSignOut);
        $('.account-bon-logout').on('click', googleSignOut);
      }
    }

    function attachSignin(element) {
      auth2.attachClickHandler(
        element,
        {},
        function (googleUser) {
          var id_token = googleUser.getAuthResponse().id_token;
          $.ajax({
            type: 'POST',
            url: base_dir + 'bonloginfacebook/controllers/front/googleconnect.php',
            data: 'accessToken=' + id_token + '',
            success: function (msg) {
              var current_url = window.location.href;
              var queryPos = current_url.lastIndexOf('?');
              queryPos = parseInt(queryPos) + 1;
              current_url = current_url.substr(queryPos);
              queryStrings = current_url.split('&');
              var noBack = 1;
              if (queryStrings.length > 0) {
                var params = queryStrings[0].split('=');
                if (params.length > 0) {
                  if (params[0] == 'back') {
                    var backUrl = decodeURIComponent(params[1]);
                    window.location.href = backUrl;
                    noBack = 0;
                  }
                }
              }
              if (noBack == 1) {
                window.location.href = window.location.href;
              }
            }
          });
          var profile = googleUser.getBasicProfile();
          var googleImg = profile.getImageUrl();
          setCookie('google_user_pic', googleImg, 1);
        },
        function (error) {
          console.log(JSON.stringify(error, undefined, 2));
        }
      );
    }

    function googleSignOut() {
      var auth2 = gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        auth2.disconnect();
        deleteCookie('google_user_pic');
        logout();
      });
    }
</script>
{* google login end *}
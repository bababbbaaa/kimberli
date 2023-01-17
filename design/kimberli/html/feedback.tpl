{* Feedback page *}
{* The canonical address of the page *}
{$canonical="/{$page->url}" scope=parent}

<!--<div class="wrap_blog_heading_page">
    <h1 class="heading_page">{if $page->name_h1|escape}{$page->name_h1|escape}{else}{$page->name|escape}{/if}</h1>
</div>

<div class="row">

    <div class="col-lg-6">

        <div class="comment_write_heading" data-language="feedback_info">{$lang->feedback_info}</div>

        <div class="block padding">
            {$page->description}
        </div>

    </div>
    <div class="col-lg-6">
        {if $message_sent}
            <div class="message_success">
                <b>{$name|escape},</b> <span data-language="feedback_message_sent">{$lang->feedback_message_sent}.</span>
            </div>
        {else}
            {$feedback_form}
        {/if}
    </div>
</div>

{* Map *}
{if $settings->iframe_map_code}
    <div class="ya_map">
    {$settings->iframe_map_code}
    </div>
{/if}-->


<div class="contacts">
    <div class="container-fluid">
        <div class="contacts_title">{$lang->index_contacts}</div>
        <div class="contacts_main">
            <div class="contacts_info">
                <div class="contacts_info_heading" data-language="feedback_info">{$lang->feedback_info}</div>
                <div class="contacts_shop_list">
                    <div class="contacts_shop active">
                        <div class="contacts_shop_location" data-lat="50.439248" data-lng="30.523167">КИЇВ, ONLINE - БУТІК KIMBERLI</div>
                        <div class="contacts_shop_content">
                            <a href="#" class="contacts_shop_link">kimberli.ua</a>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->email_order_phone}:</div>
                                <a class="binct-phone-number-1" href="tel:0932537677">+380932537677</a>
                            </div>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->index_we_open}</div>
                                <div class="time">9:30 - 22:00</div>
                            </div>
                        </div>
                        <span class="arrow">
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                            </svg>
                        </span>
                    </div>

                    <div class="contacts_shop">
                        <div class="contacts_shop_location" data-lat="50.4113730476032" data-lng="30.5223132335696">Київ, ТРЦ "OCEAN PLAZA"</div>
                        <div class="contacts_shop_content">
                            <a href="#" class="contacts_shop_link">kimberli.ua</a>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->email_order_phone}:</div>
                                <a class="binct-phone-number-1" href="tel:0932537677">+380932537677</a>
                            </div>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->index_we_open}</div>
                                <div class="time">9:30 - 22:00</div>
                            </div>
                        </div>
                        <span class="arrow">
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                            </svg>
                        </span>
                    </div>

                    <div class="contacts_shop">
                        <div class="contacts_shop_location" data-lat="50.440317357573804" data-lng="30.54435428975263">Київ, вул. Князів Острозьких, 8 - KIMBERLI BAR</div>
                        <div class="contacts_shop_content">
                            <a href="#" class="contacts_shop_link">kimberli.ua</a>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->email_order_phone}:</div>
                                <a class="binct-phone-number-1" href="tel:0932537677">+380932537677</a>
                            </div>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->index_we_open}</div>
                                <div class="time">12:00 - 02:00</div>
                            </div>
                        </div>
                        <span class="arrow">
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                            </svg>
                        </span>
                    </div>
                    <div class="contacts_shop">
                        <div class="contacts_shop_location" data-lat="46.47881102478422" data-lng="30.74047479817059">Одесса, вул. Ришельєвська, 21</div>
                        <div class="contacts_shop_content">
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->email_order_phone}:</div>
                                <a class="binct-phone-number-1" href="tel:+380673548958">+380673548958</a>
                            </div>
                            <div class="contacts_shop_detail">
                                <div class="label">{$lang->index_we_open}</div>
                                <div class="time">10:00 - 21:00</div>
                            </div>
                        </div>
                        <span class="arrow">
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="contacts_socials">
                    <a class="phone binct-phone-number-2" href="tel:0932537677" target="_blank" title="Phone">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.26036 10.6357C4.83848 12.5222 6.73818 14.0075 8.90644 15.0584C9.73197 15.4496 10.836 15.9138 12.066 15.9934C12.1422 15.9967 12.2152 16 12.2914 16C13.117 16 13.78 15.7149 14.3204 15.1281C14.3238 15.1247 14.3304 15.1181 14.3337 15.1115C14.526 14.8794 14.7448 14.6705 14.9736 14.4484C15.1294 14.2992 15.2885 14.1434 15.441 13.9843C16.1472 13.2482 16.1472 12.3133 15.4344 11.6005L13.4419 9.60796C13.1037 9.25653 12.6992 9.07087 12.2749 9.07087C11.8505 9.07087 11.4427 9.25653 11.0946 9.60464L9.90768 10.7915C9.79828 10.7286 9.68555 10.6722 9.57946 10.6191C9.44685 10.5528 9.32418 10.4898 9.21477 10.4202C8.13396 9.73394 7.15261 8.83879 6.21436 7.68835C5.74026 7.08827 5.42198 6.58433 5.19985 6.07045C5.5115 5.78864 5.80325 5.49358 6.08506 5.20514C6.18452 5.10236 6.28729 4.99959 6.39007 4.89681C6.74813 4.53875 6.94042 4.12433 6.94042 3.70327C6.94042 3.28222 6.75145 2.8678 6.39007 2.50974L5.40209 1.52176C5.28605 1.40572 5.17664 1.293 5.06392 1.17696C4.84511 0.951513 4.61634 0.719436 4.3909 0.510568C4.04942 0.175715 3.64826 0 3.22389 0C2.80284 0 2.39836 0.175715 2.04361 0.513883L0.803664 1.75383C0.352773 2.20472 0.0974891 2.75176 0.0444431 3.385C-0.0185491 4.17737 0.127327 5.01948 0.50528 6.0373C1.08547 7.6121 1.96073 9.07418 3.26036 10.6357ZM0.853395 3.45462C0.893179 3.01368 1.06226 2.64567 1.38054 2.32739L2.61386 1.09407C2.80615 0.908413 3.01833 0.812267 3.22389 0.812267C3.42613 0.812267 3.63168 0.908413 3.82066 1.1007C4.04279 1.30626 4.25165 1.52176 4.4771 1.75052C4.58982 1.86656 4.70586 1.98259 4.8219 2.10195L5.80988 3.08993C6.01543 3.29548 6.12153 3.50435 6.12153 3.7099C6.12153 3.91546 6.01543 4.12433 5.80988 4.32988C5.7071 4.43266 5.60433 4.53875 5.50155 4.64152C5.19322 4.95317 4.90478 5.24824 4.58651 5.53005C4.57988 5.53668 4.57656 5.53999 4.56993 5.54662C4.29475 5.8218 4.33785 6.08371 4.40416 6.28264C4.40748 6.29258 4.41079 6.29921 4.41411 6.30916C4.66939 6.9225 5.02414 7.50601 5.5778 8.20224C6.57242 9.42893 7.62007 10.3804 8.77383 11.1131C8.91639 11.206 9.06889 11.2789 9.21145 11.3518C9.34407 11.4182 9.46674 11.4811 9.57615 11.5508C9.58941 11.5574 9.59935 11.564 9.61261 11.5707C9.72202 11.627 9.82811 11.6535 9.93421 11.6535C10.1994 11.6535 10.3718 11.4845 10.4282 11.4281L11.6681 10.1881C11.8604 9.99586 12.0693 9.89308 12.2749 9.89308C12.5268 9.89308 12.7324 10.0489 12.8617 10.1881L14.8609 12.184C15.2587 12.5818 15.2554 13.0128 14.8509 13.4339C14.7117 13.5831 14.5658 13.7257 14.41 13.8748C14.1779 14.1003 13.9359 14.3324 13.717 14.5943C13.3358 15.0054 12.8816 15.1977 12.2948 15.1977C12.2384 15.1977 12.1787 15.1944 12.1224 15.191C11.0349 15.1214 10.0237 14.6971 9.2645 14.3357C7.20234 13.3378 5.39214 11.9221 3.89028 10.1252C2.65364 8.63655 1.82148 7.25072 1.27113 5.76544C0.929648 4.85371 0.800349 4.12101 0.853395 3.45462Z" fill="#4D4D4D"/>
                        </svg>
                    </a>
                    <a class="fb" href="https://facebook.com/Kimberli-Jewellery-House-155258051160989" target="_blank" title="Facebook">
                        {include file="svg.tpl" svgId="facebookicon"}
                    </a>
                    <a class="ins" href="https://www.instagram.com/kimberli.ua/" target="_blank"  title="Instagram">
                        {include file="svg.tpl" svgId="instagramicon"}
                    </a>
                    <a class="tl telegram" href="https://t.me/KIMBERLI_JEWELLERY_HOUSE_BOT" target="_blank" title="Telegram">
                        {include file="svg.tpl" svgId="telegrammicon"}
                    </a>
                    <a class="vb viber" href="viber://pa?chatURI=kimberlijewelleryhouse" target="_blank" title="Viber">
                        {include file="svg.tpl" svgId="vibericon"}
                    </a>
                    <a class="fbm messanger" href="https://www.messenger.com/t/kimberlijewelleryhouse" target="_blank" title="Messanger">
                        {include file="svg.tpl" svgId="messangericon"}
                    </a>
                </div>
            </div>

            <div class="contacts_map" id="map"></div>

        </div>
    </div>

    <div class="contacts_banners">
        <div class="contacts_banner" style="background-image: url('design/{$settings->theme|escape}/images/contact_banner1.png');">
            <div class="heading">{$lang->work_in} KIMBERLI JEWELRY HOUSE</div>
            <a class="binct-phone-number-1" href="tel:0932537677">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.89102 15.9536C7.2582 18.7833 10.1078 21.0112 13.3601 22.5877C14.5984 23.1745 16.2545 23.8707 18.0995 23.9901C18.2139 23.995 18.3233 24 18.4376 24C19.6759 24 20.6706 23.5723 21.4812 22.6921C21.4861 22.6871 21.4961 22.6772 21.5011 22.6672C21.7895 22.3191 22.1177 22.0058 22.4609 21.6726C22.6946 21.4488 22.9333 21.2151 23.1621 20.9764C24.2213 19.8724 24.2213 18.47 23.1521 17.4007L20.1633 14.4119C19.656 13.8848 19.0493 13.6063 18.4128 13.6063C17.7762 13.6063 17.1645 13.8848 16.6424 14.407L14.862 16.1873C14.6979 16.0928 14.5288 16.0083 14.3697 15.9287C14.1708 15.8293 13.9868 15.7348 13.8226 15.6303C12.2014 14.6009 10.7294 13.2582 9.32202 11.5325C8.61088 10.6324 8.13346 9.8765 7.80027 9.10568C8.26773 8.68297 8.70536 8.24037 9.12807 7.80771C9.27727 7.65354 9.43143 7.49938 9.5856 7.34521C10.1227 6.80812 10.4111 6.18649 10.4111 5.55491C10.4111 4.92333 10.1277 4.3017 9.5856 3.76461L8.10362 2.28264C7.92956 2.10858 7.76545 1.93949 7.59637 1.76544C7.26815 1.42727 6.92501 1.07915 6.58684 0.765852C6.07461 0.263572 5.47287 0 4.83632 0C4.20474 0 3.59803 0.263572 3.06591 0.770825L1.20598 2.63075C0.529648 3.30709 0.146722 4.12764 0.0671529 5.0775C-0.0273353 6.26606 0.191479 7.52922 0.758409 9.05595C1.62869 11.4182 2.94158 13.6113 4.89102 15.9536ZM1.28058 5.18193C1.34026 4.52051 1.59388 3.9685 2.0713 3.49109L3.92128 1.64111C4.20971 1.36262 4.52799 1.2184 4.83632 1.2184C5.13968 1.2184 5.44801 1.36262 5.73147 1.65106C6.06467 1.95939 6.37797 2.28264 6.71614 2.62578C6.88522 2.79983 7.05928 2.97389 7.23334 3.15292L8.71531 4.63489C9.02364 4.94322 9.18278 5.25653 9.18278 5.56486C9.18278 5.87319 9.02364 6.18649 8.71531 6.49482C8.56114 6.64898 8.40698 6.80812 8.25281 6.96229C7.79032 7.42976 7.35766 7.87236 6.88025 8.29507C6.8703 8.30501 6.86533 8.30999 6.85538 8.31993C6.44262 8.7327 6.50727 9.12557 6.60673 9.42395C6.6117 9.43887 6.61668 9.44882 6.62165 9.46374C7.00458 10.3838 7.53669 11.259 8.3672 12.3034C9.85911 14.1434 11.4306 15.5707 13.1612 16.6697C13.3751 16.809 13.6038 16.9184 13.8177 17.0278C14.0166 17.1272 14.2006 17.2217 14.3647 17.3261C14.3846 17.3361 14.3995 17.346 14.4194 17.356C14.5835 17.4405 14.7427 17.4803 14.9018 17.4803C15.2996 17.4803 15.5582 17.2267 15.6428 17.1421L17.5027 15.2822C17.7911 14.9938 18.1045 14.8396 18.4128 14.8396C18.7907 14.8396 19.0991 15.0734 19.293 15.2822L22.2918 18.276C22.8885 18.8728 22.8836 19.5193 22.2769 20.1509C22.068 20.3746 21.8492 20.5885 21.6154 20.8123C21.2673 21.1504 20.9043 21.4986 20.5761 21.8914C20.0042 22.5081 19.3229 22.7965 18.4426 22.7965C18.3581 22.7965 18.2686 22.7915 18.184 22.7866C16.5529 22.6821 15.0361 22.0456 13.8972 21.5035C10.804 20.0066 8.0887 17.8831 5.83591 15.1877C3.98095 12.9548 2.73271 10.8761 1.90719 8.64816C1.39496 7.28056 1.20101 6.18152 1.28058 5.18193Z" fill="white"/>
                </svg>
                <span>+380932537677</span>
            </a>
            <a href="mailto:hr@kimberli.ua">
                <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 0H2.00002C0.896953 0 0 0.896953 0 2.00002V16C0 17.103 0.896953 18 2.00002 18H22C23.103 18 24 17.103 24 16V2.00002C24 0.896953 23.103 0 22 0ZM2.00002 0.999984H22C22.0737 0.999984 22.1386 1.02684 22.2078 1.04203C20.4763 2.62673 14.7348 7.87917 12.7256 9.68944C12.5684 9.83105 12.315 9.99998 12 9.99998C11.6851 9.99998 11.4317 9.83105 11.274 9.68897C9.26494 7.87898 3.52317 2.62627 1.79194 1.04213C1.86122 1.02694 1.92628 0.999984 2.00002 0.999984ZM0.999984 16V2.00002C0.999984 1.90205 1.02952 1.81317 1.05595 1.72364C2.3812 2.93658 6.38733 6.60145 8.98495 8.96362C6.39577 11.1877 2.38861 14.9868 1.05281 16.2606C1.02923 16.1756 0.999984 16.0924 0.999984 16ZM22 17H2.00002C1.92014 17 1.84912 16.9722 1.77455 16.9544C3.15488 15.6385 7.18753 11.8175 9.7312 9.64144C10.0628 9.94223 10.3657 10.2165 10.6045 10.4317C11.0166 10.8038 11.499 11 12 11C12.501 11 12.9834 10.8037 13.395 10.4321C13.6339 10.2169 13.937 9.94237 14.2688 9.64144C16.8126 11.8173 20.8447 15.638 22.2255 16.9544C22.1509 16.9722 22.08 17 22 17ZM23 16C23 16.0924 22.9708 16.1756 22.9472 16.2606C21.6109 14.9862 17.6042 11.1875 15.0151 8.96367C17.6128 6.6015 21.6183 2.93695 22.944 1.72355C22.9705 1.81308 23 1.902 23 1.99997V16Z" fill="white"/>
                </svg>
                <span>hr@kimberli.ua</span>
            </a>
        </div>
        <div class="contacts_banner" style="background-image: url('design/{$settings->theme|escape}/images/contact_banner2.png');">
            <div class="heading">{$lang->marketing_department}</div>
            <a href="mailto:maximturava@kimberli.ua">
                <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 0H2.00002C0.896953 0 0 0.896953 0 2.00002V16C0 17.103 0.896953 18 2.00002 18H22C23.103 18 24 17.103 24 16V2.00002C24 0.896953 23.103 0 22 0ZM2.00002 0.999984H22C22.0737 0.999984 22.1386 1.02684 22.2078 1.04203C20.4763 2.62673 14.7348 7.87917 12.7256 9.68944C12.5684 9.83105 12.315 9.99998 12 9.99998C11.6851 9.99998 11.4317 9.83105 11.274 9.68897C9.26494 7.87898 3.52317 2.62627 1.79194 1.04213C1.86122 1.02694 1.92628 0.999984 2.00002 0.999984ZM0.999984 16V2.00002C0.999984 1.90205 1.02952 1.81317 1.05595 1.72364C2.3812 2.93658 6.38733 6.60145 8.98495 8.96362C6.39577 11.1877 2.38861 14.9868 1.05281 16.2606C1.02923 16.1756 0.999984 16.0924 0.999984 16ZM22 17H2.00002C1.92014 17 1.84912 16.9722 1.77455 16.9544C3.15488 15.6385 7.18753 11.8175 9.7312 9.64144C10.0628 9.94223 10.3657 10.2165 10.6045 10.4317C11.0166 10.8038 11.499 11 12 11C12.501 11 12.9834 10.8037 13.395 10.4321C13.6339 10.2169 13.937 9.94237 14.2688 9.64144C16.8126 11.8173 20.8447 15.638 22.2255 16.9544C22.1509 16.9722 22.08 17 22 17ZM23 16C23 16.0924 22.9708 16.1756 22.9472 16.2606C21.6109 14.9862 17.6042 11.1875 15.0151 8.96367C17.6128 6.6015 21.6183 2.93695 22.944 1.72355C22.9705 1.81308 23 1.902 23 1.99997V16Z" fill="white"/>
                </svg>
                <span>marketimg@kimberli.ua</span>
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="atelier-request">
            <div class="container-fluid">
                <div class="atelier-request_heading">
                    <div class="atelier-request_heading_title">{$lang->feedback_feedback}</div>
                </div>
                {if $message_sent}
                    <div class="message_success">
                        <b>{$name|escape},</b> <span data-language="feedback_message_sent">{$lang->feedback_message_sent}.</span>
                    </div>
                {else}
                    {$feedback_form}
                {/if}
               {* <form action="" class="atelier-request_form">
                    <input type="text" name="name" placeholder="Имя*" required>
                    <input type="text" name="phone" placeholder="Номер телефона*" required>
                    <textarea name="comment" placeholder="Введите сообщение"></textarea>
                    <button class="submit">замовити</button>
                </form>*}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd1JxsBzPGjhusEs2PK4kP-ZxGllebT6A&callback=initMap"></script>
<script type="text/javascript">
    /* Временно - удалить */
    $('.fliud-tag').removeClass('container-fluid');


    function CustomMarker(latlng, map, args) {
        this.latlng = latlng;
        this.args = args;
        this.setMap(map);
    }

    CustomMarker.prototype = new google.maps.OverlayView();

    CustomMarker.prototype.draw = function() {

        var self = this;

        var div = this.div;

        if (!div) {

            div = this.div = document.createElement('div');

            div.className = 'marker';

            div.style.position = 'absolute';

            div.innerHTML += '<div class="dot"></div><div class="pulse"><div>';

            if (typeof(self.args.marker_id) !== 'undefined') {
                div.dataset.marker_id = self.args.marker_id;
            }

            /*google.maps.event.addDomListener(div, "click", function(event) {
                alert('You clicked on a custom marker!');
                google.maps.event.trigger(self, "click");
            });*/

            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
        }

        var point = this.getProjection().fromLatLngToDivPixel(this.latlng);

        if (point) {
            div.style.left = (point.x - 10) + 'px';
            div.style.top = (point.y - 20) + 'px';
        }
    };

    CustomMarker.prototype.remove = function() {
        if (this.div) {
            this.div.parentNode.removeChild(this.div);
            this.div = null;
        }
    };

    CustomMarker.prototype.getPosition = function() {
        return this.latlng;
    };

    function initialize(c_lat, c_lng) {

        var myLatlng = new google.maps.LatLng(c_lat,c_lng);
        var mapOptions = {
            center: { lat: c_lat, lng: c_lng },
            zoom: 16,
            mapTypeId: 'roadmap',
            disableDefaultUI: true,
            styles: [
                {
                    "featureType": "all",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#878787"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#878787"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#878787"
                        },
                        {
                            "lightness": 17
                        },
                        {
                            "weight": 0.2
                        }
                    ]
                },

                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f8f8f8"
                        }
                    ]
                },

                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#DFDFDF"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#B2B2B2"
                        },
                        {
                            "lightness": 17
                        },
                    ]
                },

                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#B8B8B8"
                        },
                    ]
                }
            ]
        }

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);


        overlay = new CustomMarker(
            myLatlng,
            map,
            {
                marker_id: '123'
            }
        );
    }

    google.maps.event.addDomListener(window, 'load', initialize(50.439248, 30.523167));

</script>

<script>
    $('.contacts_shop_location').on('click', function() {
        $('.contacts_shop').removeClass('active');
        $(this).closest('.contacts_shop').addClass('active');

        initialize(Number($(this).attr('data-lat')), Number($(this).attr('data-lng')) );
    });
</script>
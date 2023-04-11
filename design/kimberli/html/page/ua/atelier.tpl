<div class="atelier-banner" style="background-image: url('design/{$settings->theme|escape}/images/atelier/banner-preview.jpg');">
    <div class="container-fluid">
        <div class="atelier-banner_heading">
            УНІКАЛЬНІ (АВТОРСЬКІ) - ЮВЕЛІРНІ ПРИКРАСИ<br/> З ДІАМАНТАМИ ДЛЯ ВИБАГЛИВИХ!
        </div>
        <div class="atelier-banner_descr">СТВОРЕНІ ПІД КЛІЄНТА У ЄДИНОМУ ЕКЗЕМПЛЯРІ,<br/> НАЙКРАЩИМИ ХУДОЖНИКАМИ ТА ЮВЕЛІРАМИ ЗІ СВІТОВИМ ІМʼЯМ!</div>
        <ul class="atelier-banner_list">
            <li>Підбір стилю майбутньої прикраси - ювелірним стилістом</li>
            <li>Дорогоцінне каміння та драг. матеріали зі всього світу</li>
            <li>Розробка дизайну професійним ювелірним художником</li>
            <li><b>БЕЗСТРОКОВА</b> гарантія на виріб! </li>
        </ul>
    </div>
</div>

<div class="atelier-consultation">
    <div class="container-fluid">
        <div class="atelier-consultation_container">
            <div class="atelier-consultation_avatar" style="background-image: url('design/{$settings->theme|escape}/images/atelier/manager-avatar.jpg');"></div>
            <div class="atelier-consultation_content">
                <div class="atelier-consultation_wrapp">
                    <div class="atelier-consultation_content_avatar" style="background-image: url('design/{$settings->theme|escape}/images/atelier/manager-avatar.jpg');"></div>
                    <div class="atelier-consultation_content_main">
                        <div class="atelier-consultation_heading">ОТРИМАТИ КОНСУЛЬТАЦІЮ ФАХІВЦЯ З РОЗРОБКИ ІНДИВІДУАЛЬНОЇ ПРИКРАСИ?</div>
                        <div class="atelier-consultation_descr">залиште номер телефону та ювелірний<br/> консультант звʼяжеться з вами незабаром!</div>
                    </div>
                </div>
                <form action="" method="POST" onsubmit="sendAtelierForm(this) return false;" class="about-exposition_form">
                    <input type="text" name="phone" value="" placeholder="Номер телефону">
                    <button type="submit">КОНСУЛЬТАЦІЯ</button>
                    <p class="result"></p>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="atelier-individually consultation-individually">
    <div class="atelier-individually_list">
        <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier-individually1.jpg');"></div>
        <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier-individually2.jpg');"></div>
    </div>
</div>

<div class="atelier-howwork">
    <div class="container-fluid">
        <div class="about-heading">
            Як ми працюємо
        </div>
        <div class="atelier-howwork_list">
            <div class="atelier-howwork_item">
                <div class="number">01</div>
                <div class="heading">Знайомимось</div>
                <div class="descr">Знайомство замовника з художником (офлайн / онлайн), креативне інтерв'ю, збирання образу клієнта</div>
            </div>
            <div class="atelier-howwork_item">
                <div class="number">02</div>
                <div class="heading">Обираємо найкраще</div>
                <div class="descr">Вибір стилю та дизайну майбутньої прикраси.</div>
            </div>
            <div class="atelier-howwork_item">
                <div class="number">03</div>
                <div class="heading">Фіксуємо важливі деталі</div>
                <div class="descr">Обговорення персонального бюджету клієнта.</div>
            </div>
            <div class="atelier-howwork_item">
                <div class="number">04</div>
                <div class="heading">Шукаємо найкращі вставки</div>
                <div class="descr">Індивідуальний підбір каміння.</div>
            </div>
            <div class="atelier-howwork_item">
                <div class="number">05</div>
                <div class="heading">Малюємо декілька ескізів</div>
                <div class="descr">Розробка ексклюзивного ескізу разом з художником.</div>
            </div>
            <div class="atelier-howwork_item">
                <div class="number">06</div>
                <div class="heading">Чуємо кліента</div>
                <div class="descr">Спільне доопрацювання створеного дизайнерського проекту.</div>
            </div>
            <div class="atelier-howwork_item">
                <div class="number">07</div>
                <div class="heading">Виготовляємо шедевр</div>
                <div class="descr">Перетворення проекту в унікальний ювелірний виріб.</div>
            </div>
            <a href="#" class="atelier-howwork_btn">замовити шедевр</a>
        </div>
    </div>
</div>

<div class="atelier-awards">
    <div class="about-heading">
        Наші нагороди
    </div>

    <div class="awards_slider-container">
        <div class="awards_slider_nav">
           <button class="prev">
              <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                 <path d="M19.5 12.5H6.5" stroke="#030F14" stroke-linecap="square" stroke-linejoin="round"/>
                 <path d="M12.5 5.5L5.5 12.5L12.5 19.5" stroke="#030F14" stroke-linecap="square" stroke-linejoin="round"/>
              </svg>
           </button>
           <button class="next">
              <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                 <path d="M5.5 12.5H18.5" stroke="#030F14" stroke-linecap="square" stroke-linejoin="round"/>
                 <path d="M12.5 5.5L19.5 12.5L12.5 19.5" stroke="#030F14" stroke-linecap="square" stroke-linejoin="round"/>
              </svg>
           </button>
        </div>
        <div class="awards_slider swiper-container">
           <div class="awards_slider-wrapp swiper-wrapper">
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/2.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/2.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/1.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/1.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/8.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/8.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/3.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/3.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/11.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/11.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/5.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/5.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/6.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/6.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/7.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/7.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/9.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/9.jpg" alt="">
            </div>
            <div class="atelier-slide swiper-slide" data-fancybox="awards" href="design/{$settings->theme|escape}/images/atelier/awards/10.jpg">
                <img src="design/{$settings->theme|escape}/images/atelier/awards/10.jpg" alt="">
            </div>
           </div>
        </div>
     </div>
</div>

<div class="about-exposition atelier">
    <div class="container-fluid">
        <div class="about-exposition_container">
            <div class="about-exposition_preview" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier_preview10.jpg');"></div>
            <div class="about-exposition_content">
                <div class="about-heading">
                    Авторські прикраси в KIMBERLI ATELIER: краса в єдиному екземплярі
                </div>
                <div class="about-exposition_preview mob" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier_preview10.jpg');"></div>
                <div class="about-exposition_descr">
                    <p>Кожна людина в дитинстві мріяла розкрити свій талант і прославитися. Придумати новий хімічний елемент, знайти ліки від невиліковної хвороби, створити щось прекрасне, що оцінять і полюблять люди. Бренд KIMBERLI дарує всім унікальну можливість розкрити в собі талант творця ювелірних прикрас!</p>
                    <p>Ласкаво просимо в KIMBERLI ATELIER – місце, де збуваються мрії! Цей підрозділ сформований для найвимогливіших клієнтів, що бажають пройти всі етапи створення ювелірних прикрас разом з командою KIMBERLI JEWELRY HOUSE.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="atelier-portrait">
    <div class="container-fluid">
        <div class="about-heading">
            Для кого ця послуга?
            <div class="descr">Ми розробили цей формат послуги для всіх, хто:</div>
        </div>
        <div class="atelier-portrait_list">
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service1.svg" alt="">
                </div>
                <div class="descr">
                    любить носити <b>абсолютно унікальні прикраси</b>
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service2.svg" alt="">
                </div>
                <div class="descr">
                    заздалегідь <b>готує неймовірні сюрпризи</b>
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service3.svg" alt="">
                </div>
                <div class="descr">
                    <b>дарує важливим людям щось незвичайне,</b> що підкреслює індивідуальну красу та статус власника
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service4.svg" alt="">
                </div>
                <div class="descr">
                    хоче спробувати себе в якості <b>дизайнера ювелірних прикрас</b>
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service5.svg" alt="">
                </div>
                <div class="descr">
                    У вас є <b>давня ювелірна мрія або задум</b> зробити унікальну прикрасу?
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service6.svg" alt="">
                </div>
                <div class="descr">
                    Бажаєте <b>придбати подарунковий сертифікат</b> на виготовлення унікальної фамільної коштовності?
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service7.svg" alt="">
                </div>
                <div class="descr">
                    Замислюєтесь над <b>вигідною інвестицією</b> в золото та діаманти, які постійно зростають в ціні?
                </div>
            </div>
            <div class="atelier-portrait_item">
                <div class="icon">
                    <img src="design/{$settings->theme|escape}/images/atelier_service8.svg" alt="">
                </div>
                <div class="descr">
                    Бажаєте <b>вразити навколишній світ</b> ювелірним шедевром, якого більше ні в кого не буде?
                </div>
            </div>
        </div>
    </div>
</div>

<div class="atelier-services">
    <div class="about-heading">
        наші послуги
        <div class="descr">Всі послуги можна модифікувати та скомбінувати по вашому бажанню</div>
    </div>
    <div class="atelier-services_list">
        <div class="atelier-services_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier-specialization2.jpg');">
            <div class="content">
                <div class="heading">Розробка індивідуальної ювелірно прикраси та ії виготовлення</div>
                <div class="price">від 3000$</div>
                <div class="decr">
                    <ul>
                        <li>Знайомство замовника з художником (офлайн / онлайн).</li>
                        <li>Розробка ексклюзивного ескізу разом з художником.</li>
                        <li>Спільне доопрацювання створеного дизайнерського проєкту.</li>
                        <li>Перетворення проєкту в унікальний ювелірний виріб.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="atelier-services_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier-specialization3.jpg');">
            <div class="content">
                <div class="heading">Придбання подарункового сертифіката на виготовлення ексклюзивної прикраси</div>
                <div class="price">від 3000$</div>
                <div class="decr">
                    <ul>
                        <li>Ексклюзивна та унікальна пакування подарункового сертифіката.</li>
                        <li>Безмежний строк дії сертифіката.</li>
                        <li>Можливість розширити рівень цінності подарункового сертифіката після придбання.</li>
                        <li>Сертифікат дає можливість на будь-яке індивідуальне замовлення виготовлення ювелірної прикраси.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="atelier-services_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier-specialization1.jpg');">
            <div class="content">
                <div class="heading">Виготовлення прикраси з закритого каталогу готових ескізів KIMBERLI ATELIER</div>
                <div class="price">від 3000$</div>
                <div class="decr">
                    <ul>
                        <li>Знайомимо клієнтів з асортиментом кращих готових ескізів.</li>
                        <li>До найбільш вподобаних із них підбираємо каміння.</li>
                        <li>Створюємо ексклюзивну та унікальну прикрасу класу lux.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="atelier-individually">
    <div class="container-fluid">
        <div class="about-heading">
            Прикраси, які ми виготовляли за індивідуальним замовленням
        </div>
        <div class="atelier-individually_list">
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually1.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually2.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually3.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually4.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually5.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually6.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually1.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually2.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually3.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually1.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually2.png');"></div>
            <div class="atelier-individually_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier-individually3.png');"></div>
        </div>
        <button type="button" class="about_loadmore atelier-individually_loadmore">
            завантaжити ще
        </button>
    </div>
</div>

<div class="about-exposition atelier">
    <div class="container-fluid">
        <div class="about-exposition_container">
            <div class="about-exposition_preview" style="background-image: url('design/{$settings->theme|escape}/images/atelier/advantages_over buying_ready-made.jpg');"></div>
            <div class="about-exposition_content">
                <div class="about-heading">
                    переваги перед покупкою готових прикрас
                </div>
                <div class="about-exposition_preview mob" style="background-image: url('design/{$settings->theme|escape}/images/atelier/atelier_preview11.jpg'); background-position: center center;"></div>
                <div class="about-exposition_descr">
                    <p>Кожна людина в дитинстві мріяла розкрити свій талант і прославитися. Придумати новий хімічний елемент, знайти ліки від невиліковної хвороби, створити щось прекрасне, що оцінять і полюблять люди. Бренд KIMBERLI дарує всім унікальну можливість розкрити в собі талант творця ювелірних прикрас!</p>
                    <p>Ласкаво просимо в KIMBERLI ATELIER – місце, де збуваються мрії! Цей підрозділ сформований для найвимогливіших клієнтів, що бажають пройти всі етапи створення ювелірних прикрас разом з командою KIMBERLI JEWELRY HOUSE.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-exposition atelier reverse-section">
    <div class="container-fluid">
        <div class="about-exposition_container">
            <div class="about-exposition_preview" style="background-image: url('design/{$settings->theme|escape}/images/atelier/banner-preview.jpg');"></div>
            <div class="about-exposition_content">
                <div class="about-heading">
                    основні відмінності прикраси, виготовлених на замовлення
                </div>
                <div class="about-exposition_preview mob" style="background-image: url('design/{$settings->theme|escape}/images/atelier/banner-preview.jpg');"></div>
                <div class="about-exposition_descr"> <p>Сервіс. Про нього слід сказати окремо! Крім KIMBERLI ATELIER, ми пропонуємо цілий ряд послуг:</p> <ul> <li>безстрокову гарантію на всі вироби;</li> <li>послуги персональних консультантів по стилю;</li> <li>примірку вдома;</li> <li>гнучку систему оплати;</li> <li>доставку кур'єром до дверей;</li> <li>програму лояльності;</li> <li>подарункові сертифікати на ексклюзивні ювелірні вироби;</li> <li>щедрі партнерські програми в рамках лояльності.</li> </ul> </div>
            </div>
        </div>
    </div>
</div>


<div class="atelier-movie">
    <video poster="'design/{$settings->theme|escape}/video/poster.jpg" preload="none" controls="true">
        <source type="video/mp4" src="design/{$settings->theme|escape}/video/atelier.mp4">
    </video>
    <div class="atelier-movie_plug" style="background-image: url('design/{$settings->theme|escape}/video/poster.jpg');">
        <button type="button" id="video-play">
            <svg width="89" height="89" viewBox="0 0 89 89" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="44.5" cy="44.5" r="44" stroke="#BE9948"/>
                <path d="M54 45L39 54.5263L39 35.4737L54 45Z" fill="white"/>
            </svg>
        </button>
        <div class="heading">Демонструємо за 30 секунд, як народжуються<br> шедеври KIMBERLI ATELIER!</div>
    </div>
</div>

<div class="about-gallery">
    <div class="about-heading">
        секрети процесу виробництва
    </div>
    <div class="about-gallery_list">
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview1.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview1.jpg" data-caption="Этап производства #1"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview2.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview2.jpg" data-caption="Этап производства #2"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview3.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview3.jpg" data-caption="Этап производства #3"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview4.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview4.jpg" data-caption="Этап производства #4"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview5.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview5.jpg" data-caption="Этап производства #5"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview6.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview6.jpg" data-caption="Этап производства #6"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview7.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview7.jpg" data-caption="Этап производства #7"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/about-company_preview8.jpg');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview8.jpg" data-caption="Этап производства #8"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/about-company_preview1.png');" data-fancybox="gallery" href="design/{$settings->theme|escape}/images/atelier/about-company_preview9.jpg" data-caption="Этап производства #9"></a>
    </div>
</div>

<div class="about-reviews">
    <div class="container-fluid">
        <div class="about-heading">
            відгуки наших клієнтів KIMBERLI ATELIER
        </div>
        <div class="about-reviews_list">
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Була приємно здивована, що в Україні ювелірний бренд здатний робити прикраси ні чим не поступаються по дизайну і якості світовим ювелірним домам!
                </div>
                <div class="about-reviews_name">
                    Алла, Киев
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Замовляв дружині подарунок на річницю весілля, зупинився на кільці з діамантом 2 ct. - запропонували багато варіантів дизайну на вибір, допомогли підібрати характеристики каменю і виготовили дуже швидко. Від подарунка дружина до сих пір в захваті.
                </div>
                <div class="about-reviews_name">
                    Алексей, Киев
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Довго дружина готувала до того, щоб він зробив мені подарунок у вигляді ексклюзивного ювелірного прикраси, якого більше ні у кого не буде, і ось він погодився! Дуже довго працювали з художником KIMBERLI ATELIER але результат вартий того, вже через 3 місяці я отримала подарунок про який тільки мріяла! Іменний, з побажаннями від чоловіка!
                </div>
                <div class="about-reviews_name">
                    Алина, Киев
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Познайомилася з брендом KIMBERLI, коли у них був ще магазин на Сумській у Харкові, з тих пір здобуваю прикраси тільки цього бренду. Зовсім недавно дізналася, що вони запустили нову послугу - ATELIER. У мене завжди були ідеї про те, що хочеться щось оригінальне, дизайнерське, складне і унікальне, - і ось зовсім недавно звернулася до них за своїм "шедевром". Художниця дуже швидка зрозуміла, що я хочу, промалювала вручну ескіз. Далі ми обговорили попередню вартість виготовлення прикраси, оплатила 50% і вже чекаю не дочекаюся, коли отримаю своє прикраси!
                </div>
                <div class="about-reviews_name">
                    Жанна, Харьков
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Проходячи по Рішельєвській зайшла в бутик KIMBERLI, так як давно знайома з брендом. Окремо хочу сказати за дизайн бутика - дуже модний і сучасний, я здивувалася, так як схожого нічого не бачила в Україні. Сказати що я зачарований діамантами цього бренду - нічого не сказати. все сяяло так, що без покупки не пішла. Купила доньці Пусети з діамантами. А собі замовила зустріч з художником, щоб виготовити ювелірну прикрасу, яке давно хочу! До речі, художника привозять з Києва під кожного клієнта.
                </div>
                <div class="about-reviews_name">
                    Валерия, Одесса
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Чоловік подарував сертифікат на виготовлення ексклюзивного ювелірного прикраси KIMBERLI. Раніше не була знайома з брендом. Самі Живемо в Англії, в Україні буваємо рідко. Чоловік сказав, що діаманти вигідніше купувати в Україні.
                    У шоу-румі на Московській у Києві мені розповіли всі деталі і я так загорілася! Думала, що ювелірні бренди не беруться робити прикраси за задумом клієнта, - але це не правда. У мене було 3 зустрічі з художником, я подивилася вже готові ескізи і обговорила, що б хотілося конкретно мені, від руки за 20 хвилин художниця промалювала мої ідеї на папері, а через 3 дня мені прислали повноцінний ескіз. За вартістю прикраса вийшло дорожче, ніж номінал сертифіката, довелося доповідати.
                </div>
                <div class="about-reviews_name">
                    Оксана, Киев
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Вирішив подарувати своїй мамі подарунок на ювілей - сережки з смарагдами. Вона давно мріяла про них. Походивши по ювелірним салонам не зустрів нічого, що мені сподобалося б. в магазині KIMBERLI в Ocean Plaza консультанти розповіли мені, що є можливість робити індивідуальні замовлення, і що можна підібрати ідеальні смарагди. У підсумку вирішили, що це гарна ідея, зробити прикраса індивідуально під нас. Призначили відразу зустріч з художником, якому ми показали на картинках, що нам потрібно, через 2 дні нам показали які можуть бути смарагди в нашому бюджеті (4500 $). через 2 тижні нам зробили сережки - мама залишилася дуже задоволена.
                </div>
                <div class="about-reviews_name">
                    Валентин, Киев
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    KIMBERLI люблю і знаю давно, вони завжди роблять красу і на совість. Багато прикрас у мене від цього бренду. Побачила у них в інстаграме, що вони тепер роблять індивідуальні прикраси під замовлення. У мене був Сапфір, з яким я хотіла зробити підвіс. На зустрічі з художником я привезла камінь, щоб показати, і через 2 дня художниця прислала мені 5 варіантів на зображенні. Сподобалося кілька варіантів, зупинилася на найкрасивішому. Сказали що виробництво буде не довгим, і через 2 тижні я забрала готову прикрасу в їхньому новому шоу-румі в Києві. Дуже рада, що тепер мій сапфір став частиною мого ювелірної колекції!
                </div>
                <div class="about-reviews_name">
                    Катерина, Киев
                </div>
            </div>
            <div class="about-reviews_item">
                <div class="about-reviews_descr">
                    Дуже хотілося підібрати собі ідеальний діамант на 1 ct, але щоб він був з ідеальними характеристиками. Обійшла не раз все ювелірні салони і нічого не могла знайти. Дізналася, що недавно KIMBERLI відкрили новий бутік на Рішельєвській, вирішила зайти. Виявилося, що пошук потрібно каменю з потрібними характеристиками для них не проблема. Це їхня спеціалізація! Підібрали мене ідеальний діамант з характеристиками 2/2. Якщо і купувати діаманти, то тільки кращі і з сертифікатами!
                </div>
                <div class="about-reviews_name">
                    Виктория, Одесса
                </div>
            </div>
        </div>
        <button type="button" class="about_loadmore black about-reviews_loadmore">
            завантажити ще
        </button>
    </div>
</div>

<div class="about-gallery reverse">
    <div class="about-heading">
        ідеальний подарунок KIMBERLI ATELIER
    </div>
    <div class="about-gallery_list">
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p1.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p1.jpg" data-caption="Подарок #1"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p2.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p2.jpg" data-caption="Подарок #2"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p3.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p3.jpg" data-caption="Подарок #3"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p4.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p4.jpg" data-caption="Подарок #4"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p5.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p5.jpg" data-caption="Подарок #5"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p6.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p6.jpg" data-caption="Подарок #6"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p7.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p7.jpg" data-caption="Подарок #7"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p8.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p8.jpg" data-caption="Подарок #8"></a>
        <a class="about-gallery_item" style="background-image: url('design/{$settings->theme|escape}/images/atelier/perfect_gift/p9.jpg');" data-fancybox="products" href="design/{$settings->theme|escape}/images/atelier/perfect_gift/p9.jpg" data-caption="Подарок #9"></a>
    </div>
</div>


<div class="atelier-request">
    <div class="container-fluid">
        <div class="atelier-request_heading">
            <div class="icon">
                <svg width="28" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27.914 7.78645C23.0672 1.57179 23.2739 1.72748 23.0151 1.70211L15.428 0.680164C13.5155 0.422532 12.2164 0.757382 11.5531 0.817374C11.3304 0.847343 11.1743 1.05215 11.2042 1.27478C11.2342 1.49741 11.4393 1.65387 11.6616 1.62363C12.3344 1.56194 13.541 1.247 15.3194 1.48642L20.5295 2.18817C20.1396 2.26763 14.3901 3.43925 13.9999 3.51876L7.47045 2.18817L9.72739 1.88416C9.95002 1.85419 10.1062 1.64939 10.0762 1.42675C10.0463 1.20407 9.84103 1.04788 9.61884 1.0779L4.98518 1.702C4.98453 1.70205 4.98387 1.70216 4.98321 1.70227L4.97709 1.70309C4.97086 1.70396 4.96479 1.70533 4.95861 1.70648C4.95461 1.70725 4.95051 1.70779 4.94657 1.70867C4.94324 1.70938 4.9399 1.71009 4.93662 1.71086C4.93197 1.712 4.92738 1.71337 4.92279 1.71463C4.91568 1.7166 4.90857 1.71851 4.90157 1.72086C4.89867 1.72185 4.89593 1.72305 4.89304 1.72409C4.89178 1.72453 4.89052 1.72502 4.88932 1.72551C4.88527 1.72704 4.88106 1.72846 4.87707 1.73005C4.86974 1.73306 4.86263 1.73639 4.85552 1.73984C4.8524 1.74132 4.84934 1.74268 4.84628 1.74421C4.84283 1.74596 4.8395 1.74766 4.83616 1.74946C4.83293 1.75121 4.82987 1.75318 4.82665 1.7551C4.65001 1.85802 4.73625 1.86529 0.0860232 7.78639C-0.0106639 7.91043 -0.0272888 8.07903 0.0434765 8.21952C0.20721 8.54436 -0.228264 7.90315 8.7486 19.8188C8.88389 19.9982 9.13896 20.0338 9.31833 19.8985C9.49765 19.7632 9.53331 19.5082 9.39806 19.3288L1.51331 8.87828L7.88448 10.8851C8.03728 11.2881 12.704 23.5969 12.7906 23.8253L10.5455 20.8497C10.4102 20.6703 10.1552 20.6347 9.97578 20.77C9.79641 20.9053 9.76081 21.1603 9.89605 21.3397C12.2469 24.4549 12.4891 24.7777 12.5058 24.7965C12.8028 25.1313 13.2136 25.343 13.6065 25.4093C13.6646 25.4192 14.3462 25.4189 14.4032 25.4078C14.8985 25.3116 15.3169 25.0318 15.5145 24.7717L23.4547 14.2475C23.59 14.0681 23.5543 13.813 23.375 13.6777C23.1955 13.5426 22.9406 13.5782 22.8053 13.7575L15.2092 23.8255C15.4518 23.1855 19.9371 11.3555 20.1154 10.8851L26.4866 8.87833L23.9487 12.242C23.8135 12.4214 23.8491 12.6765 24.0284 12.8118C24.2079 12.9471 24.4629 12.9114 24.5982 12.732C28.0053 8.21192 27.8217 8.4859 27.9562 8.22017C28.0273 8.07957 28.0108 7.91064 27.914 7.78645ZM13.9999 4.55098L18.9075 10.1496H9.09242L13.9999 4.55098ZM1.04617 7.87821L4.90518 2.92951L7.52147 9.91794L1.04617 7.87821ZM5.66987 2.65148C6.4753 2.81559 12.2506 3.99257 13.2323 4.19262L8.33735 9.77679L5.66987 2.65148ZM14.0449 24.6018H13.9551L8.78415 10.9631H19.2159L14.0449 24.6018ZM19.6625 9.77674L14.7676 4.19262C15.4188 4.05989 21.3288 2.85557 22.33 2.65148L19.6625 9.77674ZM20.4784 9.91783L23.0947 2.9294L26.9538 7.87816L20.4784 9.91783Z" fill="black"/>
                </svg>
            </div>
            <div class="atelier-request_heading_title">замовити ексклюзивний виріб</div>
        </div>
        {if $dop_files_footer}
            {foreach $dop_files_footer as $files}
                {$files}
            {/foreach}
        {/if}
       {* <form action="" class="atelier-request_form">
            <input type="text" name="name" placeholder="Имя*" required>
            <input type="text" name="phone" placeholder="Номер телефона*" required>
            <textarea name="comment" placeholder="Введите сообщение"></textarea>
            <button class="submit">замовити</button>
        </form>*}
        <div class="atelier-request_socials">
            <a href="">
                <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 75 75" style="enable-background:new 0 0 75 75;" xml:space="preserve"> <path class="st0" d="M69.3,12c0,0.4,0,0.7,0,1.1c-0.7,2.2-1,4.4-1.5,6.6c-3.1,14.7-6.1,29.3-9.2,44c-0.4,2.1-1.6,2.6-3.4,1.3
                c-4.5-3.2-8.9-6.5-13.4-9.7C40,54,39.2,54,37.4,55.5c-2.2,1.8-4.5,3.7-6.7,5.5c-0.6,0.5-1.6,0.9-1.6,0.9L29.4,48l24.5-24.7
                c0,0-32.4,19-33.3,18.8c-4.1-1.5-8.3-3-12.4-4.6c-0.8-0.3-1.6-0.6-2.2-1.4c0-0.4,0-0.7,0-1.1c0.4-0.7,1-1.1,1.7-1.4
                c19.6-7.5,39.1-15,58.7-22.6C67.7,10.6,68.6,10.7,69.3,12z"></path> </svg>
            </a>
            <a href="">
                <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 75 75" style="enable-background:new 0 0 75 75;" xml:space="preserve"> <path class="st0" d="M21.8,74.5c-0.4,0-0.9-0.1-1.3-0.3c-0.7-0.3-2.2-1.2-2.2-3.9c0-0.7,0-7.3,0-10.7C3.7,54.2,4.1,38.1,4.3,30.2
                l0-0.9c0.2-10.1,2.5-16.9,7.2-21.5C20.6-0.6,38.2,0.5,39,0.5c17,0.1,23.9,5.9,24.7,6.6C70,12.6,72.6,25,70.6,41l0,0
                c-2,15.9-13,18.4-16.6,19.3c-0.3,0.1-0.5,0.1-0.7,0.2c-1.7,0.5-9.5,2.3-19.2,1.9c-2.1,2.6-7.4,8.9-9.4,10.9
                C23.8,74.1,22.8,74.5,21.8,74.5z M23.9,57.7c0,0.4,0,4.7,0,8.2c3-3.5,6.8-8.1,6.9-8.1c0.6-0.7,1.4-1.1,2.3-1
                c10.4,0.7,18.5-1.5,18.5-1.5c0.2-0.1,0.6-0.2,1.1-0.3c3.3-0.8,10.9-2.5,12.4-14.6l0,0c1.7-14-0.2-24.8-5.1-29
                c-0.1-0.1-5.8-5.1-21.2-5.2c-0.3,0-16.2-0.9-23.5,5.7c-3.5,3.5-5.3,9.1-5.4,17.6l0,0.9C9.6,41,10.3,51.8,21.9,55
                C23.1,55.3,24,56.4,23.9,57.7z M67.8,40.7L67.8,40.7L67.8,40.7z"></path> <path class="st0" d="M38.6,15.1c-1.1,0-1.1,0.3-1,1.9c0,0,0,0.1,0,0.1c-0.1,0.8,0.1,1,1,1c6.2,0,11.6,4.3,13,10.1
                      c0.3,1.5,0.4,1.8,1.4,1.8c0.3,0,0.6,0,1-0.1c0.8-0.1,1-0.3,0.9-1.1c-1.1-7.4-8.3-13.6-15.4-13.7C39,15.2,38.8,15.1,38.6,15.1
                      L38.6,15.1z"></path> <path class="st0" d="M38.7,19.6c-0.9,0-0.9,0.2-0.8,1.3c0,0.2,0.1,0.4,0,0.5c-0.1,0.8,0.2,1,1,1.1c3.7,0.1,6.9,2.6,8,6
                      c0.5,1.4,0.6,1.8,1.4,1.8c0.3,0,0.7,0,1.1-0.1c0.6-0.1,0.7-0.2,0.7-0.8c-0.8-5.3-5.8-9.7-11.1-9.8
                      C39,19.6,38.9,19.6,38.7,19.6L38.7,19.6z"></path> <path class="st0" d="M38.7,23.9c-0.2,0-0.3,0-0.4,0.2c-0.3,0.7,0.1,1.5,0.1,2.3c0,0.5,0.4,0.4,0.7,0.4c1.9,0.3,3.3,1.2,3.8,3
                      c0.2,0.7,0.5,1,0.9,1c0.1,0,0.3,0,0.4-0.1c1.9-0.1,2-0.2,1.3-1.9c-1.2-2.8-3.3-4.5-6.4-4.8C39.1,23.9,38.9,23.9,38.7,23.9
                      L38.7,23.9z"></path> <path class="st0" d="M46.8,49.6c-3,0-5.8-1-8.5-2.3c-8.1-3.8-13.9-10-18.2-17.7c-1.7-3.1-2.2-6.4-0.8-9.7
                      c0.9-2.1,2-4.1,4.4-4.8c0.6-0.2,1.2-0.2,1.9-0.2c1.3-0.1,2.1,0.5,2.6,1.7c0.9,2.2,1.8,4.5,2.8,6.6c0.4,0.9,0.3,1.6-0.1,2.4
                      c-0.5,0.9-1.2,1.8-2,2.5c-0.7,0.7-0.8,1.4-0.3,2.2c3,4.9,7,8.5,12.4,10.7c0.9,0.4,1.6,0.2,2.1-0.5c0.8-1.1,1.7-2.1,2.6-3.2
                      c0.6-0.8,1.3-1,2.2-0.6c2.4,1.1,4.7,2.3,7.1,3.4c0.8,0.4,1.1,1,1.1,1.9c0,5.2-4.4,7.2-7.7,7.7C47.8,49.7,47.3,49.6,46.8,49.6z
                      "></path> </svg>
            </a>
            <a href="">
                <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 75 75" style="enable-background:new 0 0 75 75;" xml:space="preserve"> <path class="st0" d="M38.4,2.3L38.4,2.3C38.4,2.3,38.3,2.3,38.4,2.3C19,2.3,3.4,16.9,3.5,34.9c0,10.2,5.1,19.4,13.1,25.3l0,12.4
                L28.4,66c3.2,0.9,6.5,1.3,9.9,1.3c0,0,0,0,0.1,0c19.3,0,34.9-14.6,34.9-32.6C73.3,16.8,57.6,2.3,38.4,2.3z M45,46.7l-10.9-8.8
                l-17,12.7l17.3-24.5l11.1,8.8l16.8-12.7L45,46.7z"></path> </svg>
            </a>
        </div>
    </div>
</div>

<script src="design/{$settings->theme}/js/swiper.min.js"></script>
<script>
    /* Временно - удалить */
    $('.fliud-tag').removeClass('container-fluid');

    $('#video-play').on('click', function(evt) {
        var video = $('.atelier-movie video')[0];

        video.play();
        video.controls = true;

        video.addEventListener('ended', f);
        $('.atelier-movie').addClass('active');

        function f(){
            $('.atelier-movie').removeClass('active');
            video.controls = false;
        }

    });

    $(document).ready(function(){
        $(".atelier-individually_item").slice(0,5).show();
        $(".atelier-individually_loadmore").click(function(e){
            e.preventDefault();
            $(".atelier-individually_item:hidden").slice(0,3).fadeIn("slow");

            if($(".atelier-individually_item:hidden").length == 0){
                $(".atelier-individually_loadmore").fadeOut("slow");
            }
        });

        $(".about-reviews_item").slice(0,9).show();
        $(".about-reviews_loadmore").click(function(e){
            e.preventDefault();
            $(".about-reviews_item:hidden").slice(0,3).fadeIn("slow");

            if($(".about-reviews_item:hidden").length == 0){
                $(".about-reviews_loadmore").fadeOut("slow");
            }
        });
    });

    $(".atelier-howwork_btn").click(function(e) {
        e.preventDefault();
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".atelier-request").offset().top -130
        }, 1000);
    });

    let foodSwiper = new Swiper(".atelier-awards .awards_slider", {
        loop: false,
        roundLengths: true,
        //autoplay: true,
        slidesPerView: "auto",
        //centeredSlides: true,
        spaceBetween: 13,
        allowTouchMove: false,

        navigation: {
        nextEl: ".atelier-awards .awards_slider_nav .next",
        prevEl: ".atelier-awards .awards_slider_nav .prev",
        },
    });
</script>
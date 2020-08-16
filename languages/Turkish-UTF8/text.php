<?php
switch ($textpart) {
  //browsesources.php, showsource.php
  case "sources":
    $text['browseallsources'] = "Tüm Kaynaklara Göz At";
    $text['shorttitle'] = "Kısa Başlık";
    $text['callnum'] = "Çağrı Numarası";
    $text['author'] = "Yazar";
    $text['publisher'] = "Yayıncı";
    $text['other'] = "Diğer Bilgiler";
    $text['sourceid'] = "Kaynak Kimliği";
    $text['moresrc'] = "Daha fazla kaynak";
    $text['repoid'] = "Depo Kimliği";
    $text['browseallrepos'] = "Tüm Depolara Göz At";
    break;

  //changelanguage.php, savelanguage.php
  case "language":
    $text['newlanguage'] = "Yeni dil";
    $text['changelanguage'] = "Dili Değiştir";
    $text['languagesaved'] = "Dil Kaydedildi";
    $text['sitemaint'] = "Site bakımı devam ediyor";
    $text['standby'] = "Veri tabanımızı güncellerken site geçici olarak kullanılamıyor. Lütfen birkaç dakika içinde tekrar deneyin. Site uzun süre kapalı kalırsa, lütfen <a href=\"suggest.php\">site sahibiyle iletişim kurun</a>.";
    break;

  //gedcom.php, gedform.php
  case "gedcom":
    $text['gedstart'] = "Şundan başlayan GEDCOM";
    $text['producegedfrom'] = "Şundan bir GEDCOM dosyası oluşturun";
    $text['numgens'] = "Nesillerin sayısı";
    $text['includelds'] = "LDS bilgilerini dahil et";
    $text['buildged'] = "GEDCOM'u oluşturun";
    $text['gedstartfrom'] = "Şundan başlayan GEDCOM";
    $text['nomaxgen'] = "Maksimum nesil sayısını belirtmelisiniz. Önceki sayfaya dönmek ve hatayı düzeltmek için lütfen Geri düğmesini kullanın";
    $text['gedcreatedfrom'] = "Şundan oluşturulan GEDCOM";
    $text['gedcreatedfor'] = "Şunun için oluşturuldu:";
    $text['creategedfor'] = "GEDCOM oluştur";
    $text['email'] = "E-Posta adresiniz";
    $text['suggestchange'] = "Şununla ilgili bir değişiklik önerin";
    $text['yourname'] = "Adınız";
    $text['comments'] = "<br />Önerilen değişikliklerin açıklaması";
    $text['comments2'] = "Yorumlar";
    $text['submitsugg'] = "Öneri Gönder";
    $text['proposed'] = "Önerilen Değişiklik";
    $text['mailsent'] = "Teşekkür ederiz. Mesajınız gönderildi.";
    $text['mailnotsent'] = "Maalesef, mesajınız gönderilemedi. Lütfen xxx ile doğrudan yyy aracılığıyla iletişime geçin.";
    $text['mailme'] = "Bu adrese bir kopyasını gönderin";
    $text['entername'] = "Lütfen adınızı girin";
    $text['entercomments'] = "Yorumlarınızı girin";
    $text['sendmsg'] = "Mesaj Gönder";
    //added in 9.0.0
    $text['subject'] = "Konu";
    break;

  //getextras.php, getperson.php
  case "getperson":
    $text['photoshistoriesfor'] = "Şunun için Fotoğraflar ve Tarihler:";
    $text['indinfofor'] = "Şunun için kişisel bilgi:";
    $text['pp'] = "pp."; //page abbreviation
    $text['age'] = "Yaş";
    $text['agency'] = "Kuruluş";
    $text['cause'] = "Sebep";
    $text['suggested'] = "Öneren";
    $text['closewindow'] = "Bu pencereyi kapat";
    $text['thanks'] = "Teşekkür ederiz";
    $text['received'] = "Öneriniz incelenmek üzere site yöneticisine iletildi.";
    $text['indreport'] = "Kişisel Rapor";
    $text['indreportfor'] = "Şunun için Kişisel Rapor:";
    $text['general'] = "Genel";
    $text['bkmkvis'] = "<strong>Not:</strong> Bu yer işaretleri yalnızca bu bilgisayarda ve bu tarayıcıda görünür.";
    //added in 9.0.0
    $text['reviewmsg'] = "İncelemenizi gerektiren önerilen bir değişiklik var. Bu gönderi aşağıdakilerle ilgilidir:";
    $text['revsubject'] = "Önerilen değişiklik incelemenize ihtiyaç duyuyor";
    break;

  //relateform.php, relationship.php, findpersonform.php, findperson.php
  case "relate":
    $text['relcalc'] = "İlişki Hesaplama";
    $text['findrel'] = "İlişki Bul";
    $text['person1'] = "Kişi 1:";
    $text['person2'] = "Kişi 2:";
    $text['calculate'] = "Hesapla";
    $text['select2inds'] = "Lütfen iki kişi seçin.";
    $text['findpersonid'] = "Kişi Kimliği Bul";
    $text['enternamepart'] = "adın ve/veya soyadının bir kısmını girin";
    $text['pleasenamepart'] = "Lütfen ad veya soyadının bir kısmını girin.";
    $text['clicktoselect'] = "seçmek için tıklayın";
    $text['nobirthinfo'] = "Doğum bilgisi yok";
    $text['relateto'] = "Bununla ilişkisi (en alttaki satırda ilişki ifadesi oluşursa, satır sondan başa doğru yorumlanacak):";
    $text['sameperson'] = "İki kişi aynı kişidir.";
    $text['notrelated'] = "İki kişi xxx nesil içinde ilişkili değildir."; //xxx will be replaced with number of generations
    $text['findrelinstr'] = "İki kişi arasındaki ilişkiyi görüntülemek; kişileri bulmak (veya görüntülenen kişileri tutmak) için aşağıdaki 'Bul' düğmelerini kullanın, ardından 'Hesapla'yı tıklayın.";
    $text['sometimes'] = "(Bazen farklı sayıda nesilleri kontrol etmek farklı bir sonuç verir.)";
    $text['findanother'] = "Başka bir ilişki bul";
    $text['brother'] = "kardeşi<";
    $text['sister'] = "kız kardeşi<";
    $text['sibling'] = "kardeşi<";
    $text['uncle'] = "xxx amcası/dayısı<";
    $text['aunt'] = "xxx teyzesi/halası<";
    $text['uncleaunt'] = "xxx amcası/halası<";
    $text['nephew'] = "xxx erkek yeğeni<";
    $text['niece'] = "xxx kız yeğeni<";
    $text['nephnc'] = "erkek yeğeni/kız yeğeni<";
    $text['removed'] = "nesil yukarıda";
    $text['rhusband'] = "kocası< ";
    $text['rwife'] = "hanımı< ";
    $text['rspouse'] = "eşi< ";
    $text['son'] = "oğlu<";
    $text['daughter'] = "kızı<";
    $text['rchild'] = "çocuğu<";
    $text['sil'] = "damadı<";
    $text['dil'] = "gelini<";
    $text['sdil'] = "damadı veya gelini<";
    $text['gson'] = "xxx torunu<";
    $text['gdau'] = "xxx kız torunu<";
    $text['gsondau'] = "xxx torunu<";
    $text['great'] = "büyük";
    $text['spouses'] = "eşler";
    $text['is'] = "<";
    $text['changeto'] = "Şuna değiştir (Kimliği girin):";
    $text['notvalid'] = "geçerli bir Kişi Kimliği numarası değil veya bu veri tabanında yok. Lütfen tekrar deneyin.";
    $text['halfbrother'] = "üvey erkek kardeşi<";
    $text['halfsister'] = "üvey kız kardeşi<";
    $text['halfsibling'] = "üvey kardeşi<";
    //changed in 8.0.0
    $text['gencheck'] = "Kontrol edilecek maksimum nesiller";
    $text['mcousin'] = "xxx kuzeni yyy<";  //male cousin; xxx = cousin number, yyy = times removed
    $text['fcousin'] = "xxx kuzeni yyy<";  //female cousin
    $text['cousin'] = "xxx kuzeni yyy<";
    $text['mhalfcousin'] = "xxx üvey kuzeni yyy<";  //male cousin
    $text['fhalfcousin'] = "xxx üvey kuzeni yyy<";  //female cousin
    $text['halfcousin'] = "xxx üvey kuzeni yyy<";
    //added in 8.0.0
    $text['oneremoved'] = "bir nesil yukarıda";
    $text['gfath'] = "xxx büyükbabası<";
    $text['gmoth'] = "xxx büyükannesi<";
    $text['gpar'] = "xxx büyük ebeveyni<";
    $text['mothof'] = "annesi<";
    $text['fathof'] = "babası<";
    $text['parof'] = "ebeveyni<";
    $text['maxrels'] = "Gösterilecek maksimum ilişkiler";
    $text['dospouses'] = "Eş içeren ilişkileri göster";
    $text['rels'] = "İlişkiler";
    $text['dospouses2'] = "Eşleri Göster";
    $text['fil'] = "kayınbabası<";
    $text['mil'] = "kayınvalidesi<";
    $text['fmil'] = "kayınbabası ya da kayınvalidesi<";
    $text['stepson'] = "üvey oğlu<";
    $text['stepdau'] = "üvey kızı<";
    $text['stepchild'] = "üvey çocuğu<";
    $text['stepgson'] = "xxx üvey erkek torunu<";
    $text['stepgdau'] = "xxx üvey kız torunu<";
    $text['stepgchild'] = "xxx üvey torunu<";
    //added in 8.1.1
    $text['ggreat'] = "büyük";
    //added in 8.1.2
    $text['ggfath'] = "xxx nesilden dedesi<";
    $text['ggmoth'] = "xxx nesilden büyükannesi<";
    $text['ggpar'] = "xxx nesilden ebeveyni<";
    $text['ggson'] = "xxx nesilden erkek torunu<";
    $text['ggdau'] = "xxx nesilden kız torunu<";
    $text['ggsondau'] = "xxx nesilden torunu<";
    $text['gstepgson'] = "xxx nesilden üvey erkek torunu<";
    $text['gstepgdau'] = "xxx nesilden üvey kız torunu<";
    $text['gstepgchild'] = "xxx nesilden üvey torunu<";
    $text['guncle'] = "xxx nesilden amcası/dayısı<";
    $text['gaunt'] = "xxx nesilden teyzesi/halası<";
    $text['guncleaunt'] = "xxx nesilden amcası/halası<";
    $text['gnephew'] = "xxx nesilden erkek yeğeni<";
    $text['gniece'] = "xxx nesilden kız yeğeni<";
    $text['gnephnc'] = "xxx nesilden erkek yeğeni/kız yeğeni<";
    break;

  case "familygroup":
    $text['familygroupfor'] = "Şunlar için Aile Grubu Sayfası:";
    $text['ldsords'] = "LDS Yönetmelikleri";
    $text['baptizedlds'] = "Vaftiz Edilen (LDS)";
    $text['endowedlds'] = "Bağışlanan (LDS)";
    $text['sealedplds'] = "Ebeveynlere Mühürlü (LDS)";
    $text['sealedslds'] = "Eşe Mühürlü (LDS)";
    $text['otherspouse'] = "Diğer Eş";
    $text['husband'] = "Baba";
    $text['wife'] = "Anne";
    break;

  //pedigree.php
  case "pedigree":
    $text['capbirthabbr'] = "D";
    $text['capaltbirthabbr'] = "A";
    $text['capdeathabbr'] = "V";
    $text['capburialabbr'] = "D";
    $text['capplaceabbr'] = "Y";
    $text['capmarrabbr'] = "E";
    $text['capspouseabbr'] = "EŞ";
    $text['redraw'] = "Yeniden çiz";
    $text['scrollnote'] = "Notlar: Grafiği görmek için aşağı veya sağa kaydırmanız gerekebilir.";
    $text['unknownlit'] = "Bilinmeyen";
    $text['popupnote1'] = "Ek bilgiler";
    $text['popupnote2'] = "Yeni soyağacı";
    $text['pedcompact'] = "Kompakt";
    $text['pedstandard'] = "Standart";
    $text['pedtextonly'] = "Metin";
    $text['descendfor'] = "Soyundan";
    $text['maxof'] = "Maksimum";
    $text['gensatonce'] = "nesiller aynı anda görüntülenir.";
    $text['sonof'] = "oğlu";
    $text['daughterof'] = "kızı";
    $text['childof'] = "çocuğu";
    $text['stdformat'] = "Standart Format";
    $text['ahnentafel'] = "Soyağacı Tablosu";
    $text['addnewfam'] = "Yeni Aile Ekle";
    $text['editfam'] = "Aileyi Düzenle";
    $text['side'] = "(Yan Liste)";
    $text['familyof'] = "Ailesi";
    $text['paternal'] = "Baba tarafından";
    $text['maternal'] = "Anne tarafından";
    $text['gen1'] = "Kendi";
    $text['gen2'] = "Ebeveynler";
    $text['gen3'] = "Büyük Ebeveynler";
    $text['gen4'] = "Büyük Büyük Ebeveynler";
    $text['gen5'] = "2. Büyük Büyük Ebeveynler";
    $text['gen6'] = "3. Büyük Büyük Ebeveynler";
    $text['gen7'] = "4. Büyük Büyük Ebeveynler";
    $text['gen8'] = "5. Büyük Büyük Ebeveynler";
    $text['gen9'] = "6. Büyük Büyük Ebeveynler";
    $text['gen10'] = "7. Büyük Büyük Ebeveynler";
    $text['gen11'] = "8. Büyük Büyük Ebeveynler";
    $text['gen12'] = "9. Büyük Büyük Ebeveynler";
    $text['graphdesc'] = "Nesil grafiğini bu noktaya";
    $text['pedbox'] = "Kutu";
    $text['regformat'] = "Kayıt Ol";
    $text['extrasexpl'] = "= Bu kişi için en az bir fotoğraf, tarih veya başka bir medya öğesi var.";
    $text['popupnote3'] = "Yeni grafik";
    $text['mediaavail'] = "Medya Kullanılabilir";
    $text['pedigreefor'] = "İçin Soyağacı Grafiği";
    $text['pedigreech'] = "Soyağacı Grafiği";
    $text['datesloc'] = "Tarihler ve Yerler";
    $text['borchr'] = "Doğum/Alternatif - Vefat/Defin";
    $text['nobd'] = "Doğum veya Vefat Tarihleri Yok";
    $text['bcdb'] = "Tüm Doğum/Alternatif/Vefat/Defin verileri";
    $text['numsys'] = "Numaralandırma Sistemi";
    $text['gennums'] = "Nesil Numaralandırması";
    $text['henrynums'] = "Henry Numaralandırması";
    $text['abovnums'] = "d'Aboville Numaralandırması";
    $text['devnums'] = "de Villiers Numaralandırması";
    $text['dispopts'] = "Görüntüleme Seçenekleri";
    //added in 10.0.0
    $text['no_ancestors'] = "Hiçbir atası bulunamadı";
    $text['ancestor_chart'] = "Dikey ata grafiği";
    $text['opennewwindow'] = "Yeni pencerede aç";
    $text['pedvertical'] = "Dikey";
    //added in 11.0.0
    $text['familywith'] = "Aile ile";
    $text['fcmlogin'] = "Lütfen ayrıntıları görmek için giriş yapın";
    $text['isthe'] = "bu";
    $text['otherspouses'] = "diğer eşler";
    $text['parentfamily'] = "Ebeveyn aile ";
    $text['showfamily'] = "aileyi göster";
    $text['shown'] = "gösterilen";
    $text['showparentfamily'] = "ebeveyn ailesini göster";
    $text['showperson'] = "kişiyi göster";
    //added in 11.0.2
    $text['otherfamilies'] = "Diğer aileler";
    break;

  //search.php, searchform.php
  //merged with reports and showreport in 5.0.0
  case "search":
  case "reports":
    $text['noreports'] = "Hiçbir rapor yok.";
    $text['reportname'] = "Rapor Adı";
    $text['allreports'] = "Tüm Raporlar";
    $text['report'] = "Rapor";
    $text['error'] = "Hata";
    $text['reportsyntax'] = "Bu raporla çalışan sorgunun sözdizimi";
    $text['wasincorrect'] = "hatalıydı ve sonuç olarak rapor çalıştırılamadı. Lütfen adresinden sistem yöneticisine başvurun";
    $text['errormessage'] = "Hata Mesajı";
    $text['equals'] = "şuna eşit>";
    $text['endswith'] = "şununla biten>";
    $text['soundexof'] = "şununla aynı söyleyişi olan>";
    $text['metaphoneof'] = "şununla benzer söyleyişi olan>";
    $text['plusminus10'] = "+/- 10 yıl>";
    $text['lessthan'] = "şundan daha küçük>";
    $text['greaterthan'] = "şundan daha büyük>";
    $text['lessthanequal'] = "şuna eşit veya daha küçük>";
    $text['greaterthanequal'] = "şuna eşit veya daha büyük>";
    $text['equalto'] = "şuna eşit>";
    $text['tryagain'] = "Lütfen tekrar deneyin";
    $text['joinwith'] = "Şununla birleştir>";
    $text['cap_and'] = "VE";
    $text['cap_or'] = "VEYA";
    $text['showspouse'] = "Eşini göster (kişinin birden fazla eşi varsa tekrarlananları gösterecektir)";
    $text['submitquery'] = "Sorgu Gönder";
    $text['birthplace'] = "Doğum Yeri";
    $text['deathplace'] = "Vefat Yeri";
    $text['birthdatetr'] = "Doğum Yılı";
    $text['deathdatetr'] = "Vefat Yılı";
    $text['plusminus2'] = "+/- 2 yıl>";
    $text['resetall'] = "Tüm Değerleri Sıfırla";
    $text['showdeath'] = "Vefat/defin bilgilerini göster";
    $text['altbirthplace'] = "Ad Verme Yeri";
    $text['altbirthdatetr'] = "Ad Verme Yılı";
    $text['burialplace'] = "Defin Yeri";
    $text['burialdatetr'] = "Defin Yılı";
    $text['event'] = "Etkinlik";
    $text['day'] = "Gün";
    $text['month'] = "Ay";
    $text['keyword'] = "Anahtar kelime (ör. \"May\")";
    $text['explain'] = "Eşleşen etkinlikleri görmek için tarih bileşenlerini girin. Herkesin eşleşmelerini görmek için bir alanı boş bırakın.";
    $text['enterdate'] = "Lütfen aşağıdakilerden en az birini girin veya seçin: Gün, Ay, Yıl, Anahtar Kelime";
    $text['fullname'] = "Tam Adı";
    $text['birthdate'] = "Doğum Tarihi";
    $text['altbirthdate'] = "Ad Verme Tarihi";
    $text['marrdate'] = "Evlilik Tarihi";
    $text['spouseid'] = "Eşin Kimliği";
    $text['spousename'] = "Eşin Adı";
    $text['deathdate'] = "Vefat Tarihi";
    $text['burialdate'] = "Defin Tarihi";
    $text['changedate'] = "Son Değişiklik Tarihi";
    $text['gedcom'] = "Soyağacı";
    $text['baptdate'] = "Vaftiz Tarihi (LDS)";
    $text['baptplace'] = "Vaftiz Yeri (LDS)";
    $text['endldate'] = "Bağış Tarihi (LDS)";
    $text['endlplace'] = "Bağış Yeri (LDS)";
    $text['ssealdate'] = "Mühür Tarihi S (LDS)";   //Sealed to spouse
    $text['ssealplace'] = "Mühür Yeri S (LDS)";
    $text['psealdate'] = "Mühür Tarihi P (LDS)";   //Sealed to parents
    $text['psealplace'] = "Mühür Yeri P (LDS)";
    $text['marrplace'] = "Evlilik Yeri";
    $text['spousesurname'] = "Eşin Soyadı";
    $text['spousemore'] = "Eşinizin Soyadı için bir değer girerseniz, bir Cinsiyet seçmelisiniz.";
    $text['plusminus5'] = "+/- 5 yıl>";
    $text['exists'] = "var";
    $text['dnexist'] = "yok";
    $text['divdate'] = "Boşanma Tarihi";
    $text['divplace'] = "Boşanma Yeri";
    $text['otherevents'] = "Diğer Arama Kriterleri";
    $text['numresults'] = "Sayfa başına sonuçlar";
    $text['mysphoto'] = "Gizemli Fotoğraflar";
    $text['mysperson'] = "Anlaşılması Zor İnsanlar";
    $text['joinor'] = "'VEYA ile birleştir' seçeneği Eşinizin Soyadı ile kullanılamaz";
    $text['tellus'] = "Bize bildiklerini söyle";
    $text['moreinfo'] = "Daha fazla bilgi:";
    //added in 8.0.0
    $text['marrdatetr'] = "Evlilik Yılı";
    $text['divdatetr'] = "Boşanma Yılı";
    $text['mothername'] = "Annenin Adı";
    $text['fathername'] = "Babanın Adı";
    $text['filter'] = "Filtre";
    $text['notliving'] = "Yaşamayanlar";
    $text['nodayevents'] = "Bu ay için belirli bir günle ilişkili olmayan etkinlikler:";
    //added in 9.0.0
    $text['csv'] = "Virgülle ayrılmış CSV dosyası";
    //added in 10.0.0
    $text['confdate'] = "Onay Tarihi (LDS)";
    $text['confplace'] = "Onay Yeri (LDS)";
    $text['initdate'] = "Başlatma Tarihi (LDS)";
    $text['initplace'] = "Başlatma Yeri (LDS)";
    //added in 11.0.0
    $text['marrtype'] = "Evlilik Tipi";
    $text['searchfor'] = "Ara";
    $text['searchnote'] = "Not: Bu sayfa, arama yapmak için Google’ı kullanır. Dönen eşleşme sayısı, Google’ın siteyi dizine ekleyebildiği ölçüde doğrudan etkilenecektir.";
    break;

  //showlog.php
  case "showlog":
    $text['logfilefor'] = "Şunun için günlük dosyası";
    $text['mostrecentactions'] = "En Yeni Eylemler";
    $text['autorefresh'] = "Otomatik Yenile (30 saniye)";
    $text['refreshoff'] = "Otomatik Yenilemeyi Kapat";
    break;

  case "headstones":
  case "showphoto":
    $text['cemeteriesheadstones'] = "Mezarlıklar ve Mezar Taşları";
    $text['showallhsr'] = "Tüm mezar taşı kayıtlarını göster";
    $text['in'] = ".";
    $text['showmap'] = "Haritayı göster";
    $text['headstonefor'] = "Mezar taşı için";
    $text['photoof'] = "Fotoğrafı";
    $text['photoowner'] = "Sahibi/Kaynak";
    $text['nocemetery'] = "Mezarlık Yok";
    $text['iptc005'] = "Başlık";
    $text['iptc020'] = "Ek Kategoriler";
    $text['iptc040'] = "Özel Talimatlar";
    $text['iptc055'] = "Oluşturulma Tarihi";
    $text['iptc080'] = "Yazar";
    $text['iptc085'] = "Yazarın Konumu";
    $text['iptc090'] = "Şehir";
    $text['iptc095'] = "Eyalet/İl";
    $text['iptc101'] = "Ülke";
    $text['iptc103'] = "DİĞER";
    $text['iptc105'] = "Manşet";
    $text['iptc110'] = "Kaynak";
    $text['iptc115'] = "Fotoğraf Kaynağı";
    $text['iptc116'] = "Telif Hakkı Bildirimi";
    $text['iptc120'] = "Başlık";
    $text['iptc122'] = "Başlık Yazarı";
    $text['mapof'] = "Harita";
    $text['regphotos'] = "Açıklayıcı Görünüm";
    $text['gallery'] = "Sadece Küçük Resimler";
    $text['cemphotos'] = "Mezarlık Fotoğrafları";
    $text['photosize'] = "Boyutlar";
    $text['iptc010'] = "Öncelik";
    $text['filesize'] = "Dosya Boyutu";
    $text['seeloc'] = "Konumu Gör";
    $text['showall'] = "Hepsini Göster";
    $text['editmedia'] = "Medyayı Düzenle";
    $text['viewitem'] = "Bu öğeyi görüntüle";
    $text['editcem'] = "Mezarlığı Düzenle";
    $text['numitems'] = "# Öğeler";
    $text['allalbums'] = "Tüm Albümler";
    $text['slidestop'] = "Slayt Gösterisini Duraklat";
    $text['slideresume'] = "Slayt Gösterisine Devam Et";
    $text['slidesecs'] = "Her slayt için saniye:";
    $text['minussecs'] = "eksi 0,5 saniye";
    $text['plussecs'] = "artı 0,5 saniye";
    $text['nocountry'] = "Bilinmeyen ülke";
    $text['nostate'] = "Bilinmeyen eyalet";
    $text['nocounty'] = "Bilinmeyen ilçe";
    $text['nocity'] = "Bilinmeyen şehir";
    $text['nocemname'] = "Bilinmeyen mezarlık adı";
    $text['editalbum'] = "Albümü Düzenle";
    $text['mediamaptext'] = "<strong>Not:</strong> Adları göstermek için fare işaretçinizi resmin üzerine getirin. Sayfada her bir adı görmek için tıklayın.";
    //added in 8.0.0
    $text['allburials'] = "Tüm Definler";
    $text['moreinfo'] = "Bu resim hakkında daha fazla bilgi için tıklayın";
    //added in 9.0.0
    $text['iptc025'] = "Anahtar Kelimeler";
    $text['iptc092'] = "Alt konum";
    $text['iptc015'] = "Kategori";
    $text['iptc065'] = "Menşeli Program";
    $text['iptc070'] = "Program Sürümü";
    break;

  //surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
  case "surnames":
  case "places":
    $text['surnamesstarting'] = "Bu harflerle başlayan soyadları göster:";
    $text['showtop'] = "Zirveyi göster:";
    $text['showallsurnames'] = "Tüm soyadları göster";
    $text['sortedalpha'] = "alfabetik olarak sıralandı";
    $text['byoccurrence'] = "oluşumuna göre sıralandı";
    $text['firstchars'] = "İlk karakterler";
    $text['mainsurnamepage'] = "Ana soyadı sayfası";
    $text['allsurnames'] = "Tüm Soyadları";
    $text['showmatchingsurnames'] = "Eşleşen kayıtları göstermek için bir soyadına tıklayın.";
    $text['backtotop'] = "Başa dön";
    $text['beginswith'] = "şununla başlayan>";
    $text['allbeginningwith'] = "Bu harflerle başlayan tüm soyadları:";
    $text['numoccurrences'] = "parantez içinde toplam yerleşim sayısı";
    $text['placesstarting'] = "Bu harflerle başlayan en büyük yerleri göster:";
    $text['showmatchingplaces'] = "Daha küçük yerleri göstermek için bir yere tıklayın. Eşleşen kişileri göstermek için arama simgesine tıklayın.";
    $text['totalnames'] = "toplam kişiler";
    $text['showallplaces'] = "En büyük tüm yerleşim yerlerini göster";
    $text['totalplaces'] = "toplam yerler";
    $text['mainplacepage'] = "Ana yerler sayfası";
    $text['allplaces'] = "Tüm Büyük Yerleşim Yerleri";
    $text['placescont'] = "Şunu içeren tüm yerleri göster";
    //changed in 8.0.0
    $text['top30'] = "Zirvedeki xxx soyadı";
    $text['top30places'] = "Zirvedeki xxx büyük yerleşim yeri";
    //added in 12.0.0
    $text['firstnamelist'] = "Ad Listesi";
    $text['firstnamesstarting'] = "Bu harflerle başlayan adları göster:";
    $text['showallfirstnames'] = "Tüm adları göster";
    $text['mainfirstnamepage'] = "Ana ad sayfası";
    $text['allfirstnames'] = "Tüm Adlar";
    $text['showmatchingfirstnames'] = "Eşleşen kayıtları göstermek için bir ad üzerine tıklayın.";
    $text['allfirstbegwith'] = "Bu harflerle başlayan tüm adlar:";
    $text['top30first'] = "Zirvedeki xxx ad";
    $text['allothers'] = "Tüm diğerleri";
    $text['amongall'] = "(tüm adlar arasında)";
    $text['justtop'] = "Sadece zirvedeki xxx";
    break;

  //whatsnew.php
  case "whatsnew":
    $text['pastxdays'] = "(xx gün geçmiş)";

    $text['photo'] = "Fotoğraf";
    $text['history'] = "Geçmiş/Belge";
    $text['husbid'] = "Baba Kimliği";
    $text['husbname'] = "Babanın Adı";
    $text['wifeid'] = "Anne Kimliği";
    //added in 11.0.0
    $text['wifename'] = "Annenin Adı";
    break;

  //timeline.php, timeline2.php
  case "timeline":
    $text['text_delete'] = "Sil";
    $text['addperson'] = "Kişi Ekle";
    $text['nobirth'] = "Şu kişinin geçerli bir doğum tarihi yok ve eklenemedi";
    $text['event'] = "Etkinlik(ler)";
    $text['chartwidth'] = "Grafik genişliği";
    $text['timelineinstr'] = "İnsanları Ekle";
    $text['togglelines'] = "Satırları Değiştir";
    //changed in 9.0.0
    $text['noliving'] = "Aşağıdaki kişi canlı veya özel olarak işaretlendi ve uygun izinlerle giriş yapmadığınız için eklenemedi";
    break;

  //browsetrees.php
  //login.php, newacctform.php, addnewacct.php
  case "trees":
  case "login":
    $text['browsealltrees'] = "Tüm Soyağaçlarına Göz At";
    $text['treename'] = "Soyağacı Adı";
    $text['owner'] = "Sahibi";
    $text['address'] = "Adres";
    $text['city'] = "Şehir";
    $text['state'] = "Eyalet/İl";
    $text['zip'] = "Zip/Posta Kodu";
    $text['country'] = "Ülke";
    $text['email'] = "E-Posta";
    $text['phone'] = "Telefon";
    $text['username'] = "Kullanıcı adı";
    $text['password'] = "Şifre";
    $text['loginfailed'] = "Giriş başarısız.";

    $text['regnewacct'] = "Yeni Kullanıcı Hesabına Kaydolun";
    $text['realname'] = "Gerçek Adın";
    $text['phone'] = "Telefon";
    $text['email'] = "E-posta";
    $text['address'] = "Adres";
    $text['acctcomments'] = "Notlar veya Yorumlar";
    $text['submit'] = "Gönder";
    $text['leaveblank'] = "(yeni bir soyağacı isterse boş bırakın)";
    $text['required'] = "Zorunlu alanlar";
    $text['enterpassword'] = "Lütfen bir şifre girin.";
    $text['enterusername'] = "Lütfen bir kullanıcı adı girin.";
    $text['failure'] = "Üzgünüz, fakat girdiğiniz kullanıcı adı zaten kullanılıyor. Lütfen önceki sayfaya geri dönmek ve farklı bir kullanıcı adı seçmek için tarayıcınızdaki Geri düğmesini kullanın.";
    $text['success'] = "Teşekkürler. Kaydınızı aldık. Hesabınız etkin olduğunda veya daha fazla bilgiye ihtiyaç duyulduğunda sizinle iletişim kuracağız.";
    $text['emailsubject'] = "Yeni TNG kullanıcı kaydı isteği";
    $text['website'] = "Web Sitesi";
    $text['nologin'] = "Giriş yapmadın mı?";
    $text['loginsent'] = "Giriş bilgileri gönderildi";
    $text['loginnotsent'] = "Giriş bilgileri gönderilmedi";
    $text['enterrealname'] = "Lütfen gerçek adınızı girin.";
    $text['rempass'] = "Bu bilgisayarda kayıtlı kal";
    $text['morestats'] = "Daha fazla istatistik";
    $text['accmail'] = "<strong>NOT:</strong> Hesabınızla ilgili site yöneticisinden posta almak için, lütfen bu etki alanından gelen postaları engellemediğinizden emin olun.";
    $text['newpassword'] = "Yeni Şifre";
    $text['resetpass'] = "Şifrenizi sıfırlayın";
    $text['nousers'] = "Bu form en az bir kullanıcı kaydı bulunana kadar kullanılamaz. Site sahibi sizseniz, lütfen Yönetici hesabınızı oluşturmak için Yönetici/Kullanıcılar kısmına gidin.";
    $text['noregs'] = "Üzgünüz, ancak şu anda yeni kullanıcı kayıtları kabul etmiyoruz. Lütfen, doğrudan bu sitede bir şey ile ilgili yorum veya sorularınız varsa <a href=\"suggest.php\">bize ulaşın</a>.";
    //changed in 8.0.0
    $text['emailmsg'] = "Bir TNG kullanıcı hesabı için yeni bir istek aldınız. Lütfen TNG Yönetici alanınıza giriş yapın ve bu yeni hesaba uygun izinleri atayın.";
    $text['accactive'] = "Hesap etkinleştirildi, ancak siz onları atayana kadar kullanıcı özel haklara sahip olmayacak.";
    $text['accinactive'] = "Hesap ayarlarına erişmek için Yönetici/Kullanıcılar/İncele'ye gidin. Siz kaydı, en az bir kez düzenleyene ve kaydedene kadar hesap etkin olmaya devam eder.";
    $text['pwdagain'] = "Tekrar şifre";
    $text['enterpassword2'] = "Lütfen şifrenizi tekrar giriniz.";
    $text['pwdsmatch'] = "Şifreleriniz uyuşmuyor. Lütfen her alana aynı şifreyi girin.";
    //added in 8.0.0
    $text['acksubject'] = "Kaydolduğunuz için teşekkürler"; //for a new user account
    $text['ackmessage'] = "Bir kullanıcı hesabı isteğiniz alındı. Hesabınız site yöneticisi tarafından incelenene kadar etkin olmayacak. Girişiniz kullanıma hazır olduğunda e-posta ile bilgilendirileceksiniz.";
    //added in 12.0.0
    $text['switch'] = "Değişim";
    break;

  //added in 10.0.0
  case "branches":
    $text['browseallbranches'] = "Tüm Soyağacı Şubelerine Göz Atın";
    break;

  //statistics.php
  case "stats":
    $text['quantity'] = "Miktar";
    $text['totindividuals'] = "Toplam Kişiler";
    $text['totmales'] = "Toplam Erkekler";
    $text['totfemales'] = "Toplam Kadınlar";
    $text['totunknown'] = "Toplam Bilinmeyen Cinsiyet";
    $text['totliving'] = "Toplam Yaşayanlar";
    $text['totfamilies'] = "Toplam Aileler";
    $text['totuniquesn'] = "Toplam Benzersiz Soyadları";
    //$text['totphotos'] = "Total Photos";
    //$text['totdocs'] = "Total Histories &amp; Documents";
    //$text['totheadstones'] = "Total Headstones";
    $text['totsources'] = "Toplam Kaynaklar";
    $text['avglifespan'] = "Ortalama Ömür";
    $text['earliestbirth'] = "En Erken Doğum";
    $text['longestlived'] = "En Uzun Ömürlü";
    $text['days'] = "gün";
    $text['age'] = "Yaş";
    $text['agedisclaimer'] = "Yaşa bağlı hesaplamalar kayıtlı doğum <em>ve</em> vefat tarihleri olan kişilere dayanmaktadır.  Eksik tarih alanlarının varlığı nedeniyle (örneğin, yalnızca \"1945\" veya \"1860 ÖNCESİ\" olarak listelenen bir vefat tarihi), bu hesaplamalar %100 doğru olamaz.";
    $text['treedetail'] = "Bu soyağacı hakkında daha fazla bilgi";
    $text['total'] = "Toplam";
    //added in 12.0
    $text['totdeceased'] = "Toplam Vefat Edenler";
    break;

  case "notes":
    $text['browseallnotes'] = "Tüm Notlara Göz Atın";
    break;

  case "help":
    $text['menuhelp'] = "Menü Tuşu";
    break;

  case "install":
    $text['perms'] = "İzinlerin tümü ayarlandı.";
    $text['noperms'] = "Bu dosyalar için izinler ayarlanamadı:";
    $text['manual'] = "Lütfen bunları manuel olarak ayarlayın.";
    $text['folder'] = "Klasör";
    $text['created'] = "oluşturuldu";
    $text['nocreate'] = "oluşturulamadı. Lütfen manuel olarak oluşturun.";
    $text['infosaved'] = "Bilgi kaydedildi, bağlantı doğrulandı!";
    $text['tablescr'] = "Tablolar oluşturuldu!";
    $text['notables'] = "Aşağıdaki tablolar oluşturulamadı:";
    $text['nocomm'] = "TNG veri tabanınızla iletişim kurmuyor. Hiçbir tablo oluşturulmadı.";
    $text['newdb'] = "Bilgi kaydedildi, bağlantı doğrulandı, yeni veri tabanı oluşturuldu:";
    $text['noattach'] = "Bilgi kaydedildi. Bağlantı yapıldı ve veri tabanı oluşturuldu, ancak TNG buna eklenemiyor.";
    $text['nodb'] = "Bilgi kaydedildi. Bağlantı yapıldı, ancak veri tabanı mevcut değil ve burada oluşturulamadı. Lütfen veri tabanı adının doğru olduğunu ve veri tabanı kullanıcısının uygun erişime sahip olduğunu doğrulayın veya oluşturmak için kontrol panelinizi kullanın.";
    $text['noconn'] = "Bilgi kaydedildi ancak bağlantı başarısız oldu. Aşağıdakilerden biri veya daha fazlası yanlış:";
    $text['exists'] = "zaten var.";
    $text['loginfirst'] = "Öncelikle giriş yapmalısınız.";
    $text['noop'] = "Hiçbir işlem yapılmadı.";
    //added in 8.0.0
    $text['nouser'] = "Kullanıcı oluşturulmadı. Kullanıcı adı zaten mevcut olabilir.";
    $text['notree'] = "Soyağacı oluşturulmadı. Soyağacı Kimliği zaten mevcut olabilir.";
    $text['infosaved2'] = "Bilgi kaydedildi";
    $text['renamedto'] = "yeniden adlandırıldı";
    $text['norename'] = "yeniden adlandırılamadı";
    break;

  case "imgviewer":
    $text['zoomin'] = "Yakınlaştır";
    $text['zoomout'] = "Uzaklaştır";
    $text['magmode'] = "Büyütme Modu";
    $text['panmode'] = "Kaydırma Modu";
    $text['pan'] = "Resmin içinde hareket etmek için tıklayın ve sürükleyin";
    $text['fitwidth'] = "Genişliğe Sığdır";
    $text['fitheight'] = "Yüksekliğe Sığdır";
    $text['newwin'] = "Yeni Pencere";
    $text['opennw'] = "Resmi yeni pencerede aç";
    $text['magnifyreg'] = "Resmin bir bölgesini büyütmek için tıklayın";
    $text['imgctrls'] = "Görüntü Kontrollerini Etkinleştir";
    $text['vwrctrls'] = "Resim Görüntüleyici Kontrollerini Etkinleştir";
    $text['vwrclose'] = "Resim Görüntüleyiciyi Kapat";
    break;

  case "dna":
    $text['test_date'] = "Test tarihi";
    $text['links'] = "İlgili bağlantılar";
    $text['testid'] = "Test Kimliği";
    //added in 12.0.0
    $text['mode_values'] = "Mod Değerleri";
    $text['compareselected'] = "Seçileni Karşılaştır";
    $text['dnatestscompare'] = "Y-DNA Testlerini Karşılaştır";
    $text['keep_name_private'] = "Adı Özel Tut";
    $text['browsealltests'] = "Tüm Testlere Göz Atın";
    $text['all_dna_tests'] = "Tüm DNA testleri";
    $text['fastmutating'] = "Hızlı&nbsp;Mutasyon";
    $text['alltypes'] = "Tüm Türler";
    $text['allgroups'] = "Tüm Gruplar";
    $text['Ydna_LITbox_info'] = "Bu kişiye bağlı test(ler) mutlaka bu kişi tarafından alınmamıştır.<br />'Haplogroup' sütunu; sonuç 'Tahmin Edilirse' verileri kırmızı veya test 'Onaylanırsa' yeşil olarak görüntüler";
    //added in 12.1.0
    $text['dnatestscompare_mtdna'] = "Seçilen mtDNA Testlerini Karşılaştır";
    $text['dnatestscompare_atdna'] = "Seçilen atDNA Testlerini Karşılaştır";
    $text['chromosome'] = "Chr";
    $text['centiMorgans'] = "cM";
    $text['snps'] = "SNPs";
    $text['y_haplogroup'] = "Y-DNA";
    $text['mt_haplogroup'] = "mtDNA";
    $text['sequence'] = "Ref";
    $text['extra_mutations'] = "Ekstra Mutasyonlar";
    $text['mrca'] = "MRC Ataları";
    $text['ydna_test'] = "Y-DNA Testleri";
    $text['mtdna_test'] = "mtDNA (Mitokondriyal) Testleri";
    $text['atdna_test'] = "atDNA (otozomal) Testleri";
    $text['segment_start'] = "Başlat";
    $text['segment_end'] = "Son";
    $text['suggested_relationship'] = "Önerildi";
    $text['actual_relationship'] = "Gerçek";
    $text['12markers'] = "İşaretleyiciler 1-12";
    $text['25markers'] = "İşaretleyiciler 13-25";
    $text['37markers'] = "İşaretleyiciler 26-37";
    $text['67markers'] = "İşaretleyiciler 38-67";
    $text['111markers'] = "İşaretleyiciler 68-111";
    break;
}

//common
$text['matches'] = "Eşleştirmeler";
$text['description'] = "Açıklama";
$text['notes'] = "Notlar";
$text['status'] = "Durum";
$text['newsearch'] = "Yeni Arama";
$text['pedigree'] = "Soyağacı";
$text['seephoto'] = "Fotoğrafa bakın";
$text['andlocation'] = "&amp; konum";
$text['accessedby'] = "tarafından erişilen";
$text['family'] = "Aile"; //from getperson
$text['children'] = "Çocuklar";  //from getperson
$text['tree'] = "Soyağacı";
$text['alltrees'] = "Tüm Soyağaçları";
$text['nosurname'] = "[soyadı yok]";
$text['thumb'] = "Minik resim";  //as in Thumbnail
$text['people'] = "İnsanlar";
$text['title'] = "Ünvan";  //from getperson
$text['suffix'] = "Sonek";  //from getperson
$text['nickname'] = "Lakap";  //from getperson
$text['lastmodified'] = "Son Değiştirilen";  //from getperson
$text['married'] = "Evlilik";  //from getperson
//$text['photos'] = "Photos";
$text['name'] = "Ad"; //from showmap
$text['lastfirst'] = "Soyadı, Adı";  //from search
$text['bornchr'] = "Doğum/Ad Verildi";  //from search
$text['individuals'] = "Kişiler";  //from whats new
$text['families'] = "Aileler";
$text['personid'] = "Kişi Kimliği";
$text['sources'] = "Kaynaklar";  //from getperson (next several)
$text['unknown'] = "Bilinmeyen";
$text['father'] = "Baba";
$text['mother'] = "Anne";
$text['christened'] = "Ad Verildi";
$text['died'] = "Vefat Etti";
$text['buried'] = "Defnedildi";
$text['spouse'] = "Eş";  //from search
$text['parents'] = "Ebeveynler";  //from pedigree
$text['text'] = "Metin";  //from sources
$text['language'] = "Dil";  //from languages
$text['descendchart'] = "Nesil";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Kişi";
$text['edit'] = "Düzenle";
$text['date'] = "Tarih";
$text['place'] = "Yer";
$text['login'] = "Oturum Aç";
$text['logout'] = "Kapat";
$text['groupsheet'] = "Aile Grubu Sayfası";
$text['text_and'] = "ve";
$text['generation'] = "Nesil";
$text['filename'] = "Dosya adı";
$text['id'] = "Kimlik";
$text['search'] = "Ara";
$text['user'] = "Kullanıcı";
$text['firstname'] = "Adı";
$text['lastname'] = "Soyadı";
$text['searchresults'] = "Arama Sonuçları";
$text['diedburied'] = "Vefat Etti/Defnedildi";
$text['homepage'] = "Ana Sayfa";
$text['find'] = "Bul...";
$text['relationship'] = "İlişki";    //in German, Verwandtschaft
$text['relationship2'] = "İlişki"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Zaman Çizelgesi";
$text['yesabbr'] = "E";               //abbreviation for 'yes'
$text['divorced'] = "Boşandı";
$text['indlinked'] = "Şununla bağlantılı>";
$text['branch'] = "Soyağacı Şubesi";
$text['moreind'] = "Daha fazla kişi";
$text['morefam'] = "Daha fazla aile";
$text['source'] = "Kaynak";
$text['surnamelist'] = "Soyadı Listesi";
$text['generations'] = "Nesil";
$text['refresh'] = "Yenile";
$text['whatsnew'] = "Yeni olan ne?";
$text['reports'] = "Raporlar";
$text['placelist'] = "Yer Listesi";
$text['baptizedlds'] = "Vaftiz Edilen (LDS)";
$text['endowedlds'] = "Bağışlanan (LDS)";
$text['sealedplds'] = "Mühürlü P (LDS)";
$text['sealedslds'] = "Mühürlü S (LDS)";
$text['ancestors'] = "Atalar";
$text['descendants'] = "Nesiller";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Son GEDCOM İçe Aktarma Tarihi";
$text['type'] = "Tür";
$text['savechanges'] = "Değişiklikleri Kaydet";
$text['familyid'] = "Aile Kimliği";
$text['headstone'] = "Mezar Taşları";
$text['historiesdocs'] = "Tarihçeler";
$text['anonymous'] = "anonim";
$text['places'] = "Yerler";
$text['anniversaries'] = "Tarihler ve Yıldönümleri";
$text['administration'] = "Yönetim";
$text['help'] = "Yardım";
//$text['documents'] = "Documents";
$text['year'] = "Yıl";
$text['all'] = "Tüm";
$text['repository'] = "Depo";
$text['address'] = "Adres";
$text['suggest'] = "Öneri";
$text['editevent'] = "Bu etkinlik için bir değişiklik önerin";
$text['findplaces'] = "Bu konumda etkinlikleri olan tüm kişileri bul";
$text['morelinks'] = "Daha Fazla Bağlantı";
$text['faminfo'] = "Aile Bilgisi";
$text['persinfo'] = "Kişisel Bilgi";
$text['srcinfo'] = "Kaynak Bilgisi";
$text['fact'] = "Gerçek";
$text['goto'] = "Bir sayfa seç";
$text['tngprint'] = "Yazdır";
$text['databasestatistics'] = "İstatistik"; //needed to be shorter to fit on menu
$text['child'] = "Çocuk";  //from familygroup
$text['repoinfo'] = "Depo Bilgileri";
$text['tng_reset'] = "Sıfırla";
$text['noresults'] = "Şunun için sonuç bulunamadı";
$text['allmedia'] = "Tüm Medya";
$text['repositories'] = "Depolar";
$text['albums'] = "Albümler";
$text['cemeteries'] = "Mezarlıklar";
$text['surnames'] = "Soyadları";
$text['dates'] = "Tarihler";
$text['link'] = "Bağlantı";
$text['media'] = "Medya";
$text['gender'] = "Cinsiyet";
$text['latitude'] = "Enlem";
$text['longitude'] = "Boylam";
$text['bookmarks'] = "Yer İşaretleri";
$text['bookmark'] = "Yer İşareti";
$text['mngbookmarks'] = "Yer İşaretlerine Git";
$text['bookmarked'] = "Yer İşareti Eklendi";
$text['remove'] = "Kaldır";
$text['find_menu'] = "Bul";
$text['info'] = "Bilgi"; //this needs to be a very short abbreviation
$text['cemetery'] = "Mezarlık";
$text['gmapevent'] = "Etkinlik Haritası";
$text['gevents'] = "Etkinlik";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Google Earth'e bağlantı";
$text['googlemaplink'] = "Google Haritalar'a bağlantı";
$text['gmaplegend'] = "Pin Efsanesi";
$text['unmarked'] = "İşaretsiz";
$text['located'] = "Bulunan";
$text['albclicksee'] = "Bu albümdeki tüm öğeleri görmek için tıklayın";
$text['notyetlocated'] = "Henüz bulunmadı";
$text['cremated'] = "Yakıldı";
$text['missing'] = "Eksiklik";
$text['pdfgen'] = "PDF Oluşturucu";
$text['blank'] = "Boş Grafik";
$text['none'] = "Yok";
$text['fonts'] = "Fontlar";
$text['header'] = "Üstbilgi";
$text['data'] = "Veri";
$text['pgsetup'] = "Sayfa Yapısı";
$text['pgsize'] = "Sayfa Boyutu";
$text['orient'] = "Oryantasyon"; //for a page
$text['portrait'] = "Portre";
$text['landscape'] = "Geniş Görünüm";
$text['tmargin'] = "Üst Kenar Boşluğu";
$text['bmargin'] = "Alt Kenar Boşluğu";
$text['lmargin'] = "Sol Kenar Boşluğu";
$text['rmargin'] = "Sağ Kenar Boşluğu";
$text['createch'] = "Grafik Oluştur";
$text['prefix'] = "Önek";
$text['mostwanted'] = "En Çok Aranan";
$text['latupdates'] = "Son Güncellemeler";
$text['featphoto'] = "Öne Çıkan Fotoğraf";
$text['news'] = "Haberler";
$text['ourhist'] = "Aile Tarihimiz";
$text['ourhistanc'] = "Aile Tarihimiz ve Soyumuz";
$text['ourpages'] = "Aile Şecere Sayfalarımız";
$text['pwrdby'] = "Bu siteyi destekleyen:";
$text['writby'] = "Yazan:";
$text['searchtngnet'] = "TNG ağını Ara (GENDEX)";
$text['viewphotos'] = "Tüm fotoğrafları görüntüle";
$text['anon'] = "Şu anda anonimsin";
$text['whichbranch'] = "Soyağacında hangi şubedesin?";
$text['featarts'] = "Özellik Makaleleri";
$text['maintby'] = "Bakımını sürdüren:";
$text['createdon'] = "Oluşturuldu";
$text['reliability'] = "Güvenilirlik";
$text['labels'] = "Etiketler";
$text['inclsrcs'] = "Kaynakları Dahil Et";
$text['cont'] = "(devam)"; //abbreviation for continued
$text['mnuheader'] = "Ana Sayfa";
$text['mnusearchfornames'] = "Ara";
$text['mnulastname'] = "Soyadı";
$text['mnufirstname'] = "Adı";
$text['mnusearch'] = "Ara";
$text['mnureset'] = "Baştan Başla";
$text['mnulogon'] = "Oturum Aç";
$text['mnulogout'] = "Çıkış Yap";
$text['mnufeatures'] = "Diğer Özellikler";
$text['mnuregister'] = "Bir Kullanıcı Hesabı İçin Kayıt Olun";
$text['mnuadvancedsearch'] = "Gelişmiş Arama";
$text['mnulastnames'] = "Soyadları";
$text['mnustatistics'] = "İstatistik";
$text['mnuphotos'] = "Fotoğraflar";
$text['mnuhistories'] = "Tarihçeler";
$text['mnumyancestors'] = "Ataları için Fotoğraflar &amp; Tarihçeler [Kişi]";
$text['mnucemeteries'] = "Mezarlıklar";
$text['mnutombstones'] = "Mezar Taşları";
$text['mnureports'] = "Raporlar";
$text['mnusources'] = "Kaynaklar";
$text['mnuwhatsnew'] = "Yeni ne var?";
$text['mnushowlog'] = "Erişim Günlüğü";
$text['mnulanguage'] = "Dili Değiştir";
$text['mnuadmin'] = "Yönetim";
$text['welcome'] = "Hoş geldiniz";
$text['contactus'] = "Bizimle İletişime Geçin";
//changed in 8.0.0
$text['born'] = "Doğum";
$text['searchnames'] = "İnsanları Ara";
//added in 8.0.0
$text['editperson'] = "Kişi Düzenle";
$text['loadmap'] = "Haritayı yükle";
$text['birth'] = "Doğum";
$text['wasborn'] = "doğdu";
$text['startnum'] = "İlk Sayı";
$text['searching'] = "Aranıyor";
//moved here in 8.0.0
$text['location'] = "Konum";
$text['association'] = "İlişkilendirme";
$text['collapse'] = "Daralt";
$text['expand'] = "Genişlet";
$text['plot'] = "Arsa";
$text['searchfams'] = "Aileleri Ara";
//added in 8.0.2
$text['wasmarried'] = "Evlilik";
$text['anddied'] = "Vefat Etti";
//added in 9.0.0
$text['share'] = "Paylaş";
$text['hide'] = "Gizle";
$text['disabled'] = "Kullanıcı hesabınız devre dışı bırakıldı. Daha fazla bilgi için lütfen site yöneticisine başvurun.";
$text['contactus_long'] = "Bu sitedeki bilgilerle ilgili herhangi bir sorunuz veya yorumunuz varsa, lütfen <span class=\"emphasis\"><a href=\"suggest.php\">bize ulaşın</a></span>. Sizden haber almak için bekliyoruz.";
$text['features'] = "Özellikler";
$text['resources'] = "Kaynaklar";
$text['latestnews'] = "En Son Haberler";
$text['trees'] = "Soyağaçları";
$text['wasburied'] = "defnedildi";
//moved here in 9.0.0
$text['emailagain'] = "Tekrar e-posta";
$text['enteremail2'] = "Lütfen e-posta adresinizi tekrar girin.";
$text['emailsmatch'] = "E-postalarınız eşleşmiyor. Lütfen her alana aynı e-posta adresini girin.";
$text['getdirections'] = "Yol tarifi almak için tıklayın";
$text['calendar'] = "Takvim";
//changed in 9.0.0
$text['directionsto'] = " için ";
$text['slidestart'] = "Slayt Gösterisi";
$text['livingnote'] = "En az bir yaşayan veya özel kişi bu notla bağlantılıdır - Ayrıntıları gizli tutulmuştur.";
$text['livingphoto'] = "En az bir yaşayan veya özel kişi bu öğe ile bağlantılıdır - Ayrıntıları gizli tutulmuştur.";
$text['waschristened'] = "vaftiz edildi";
//added in 10.0.0
$text['branches'] = "Soyağacı Şubeleri";
$text['detail'] = "Ayrıntı";
$text['moredetail'] = "Daha fazla ayrıntı";
$text['lessdetail'] = "Daha az ayrıntı";
$text['otherevents'] = "Diğer Etkinlikler";
$text['conflds'] = "Onaylanan (LDS)";
$text['initlds'] = "Başlatan (LDS)";
$text['wascremated'] = "yakıldı";
//moved here in 11.0.0
$text['text_for'] = ":";
//added in 11.0.0
$text['searchsite'] = "Bu siteyi ara";
$text['searchsitemenu'] = "Arama Sitesi";
$text['kmlfile'] = "Bu konumu Google Earth’te göstermek için bir .kml dosyası indirin";
$text['download'] = "İndirmek için tıklayın";
$text['more'] = "Daha";
$text['heatmap'] = "Sıcaklık Haritası";
$text['refreshmap'] = "Haritayı Yenile";
$text['remnums'] = "Sayıları ve Raptiyeleri Temizle";
$text['photoshistories'] = "Fotoğraflar &amp; Tarihçeler";
$text['familychart'] = "Aile Grafiği";
//added in 12.0.0
$text['firstnames'] = "Adlar";
//moved here in 12.0.0
$text['dna_test'] = "DNA Testi";
$text['test_type'] = "Test Türü";
$text['test_info'] = "Test Bilgisi";
$text['takenby'] = "Tarafından alınan";
$text['haplogroup'] = "Haplogroup";
$text['hvr1'] = "HVR1";
$text['hvr2'] = "HVR2";
$text['relevant_links'] = "İlgili bağlantılar";
$text['nofirstname'] = "[ad yok]";
//added in 12.0.1
$text['cookieuse'] = "Not: Bu site çerezleri kullanır.";
$text['dataprotect'] = "Veri Koruma Politikası";
$text['viewpolicy'] = "Politikayı görüntüle";
$text['understand'] = "Anlıyorum";
$text['consent'] = "Bu siteden toplanan kişisel bilgileri saklaması için onay veriyorum. Site sahibinden bu bilgileri istediği zaman kaldırmasını isteyebileceğimi biliyorum.";
$text['consentreq'] = "Lütfen bu sitenin kişisel bilgilerini saklaması için onay ver.";

//added in 12.1.0
$text['testsarelinked'] = "DNA testleri ile ilişkili";
$text['testislinked'] = "testi ile ilişkili";

//added in 12.2
$text['quicklinks'] = "Hızlı Bağlantılar";
$text['yourname'] = "Adınız";
$text['youremail'] = "E-Posta Adresiniz";
$text['liketoadd'] = "Eklemek istediğiniz herhangi bir bilgi";
$text['webmastermsg'] = "Webmaster Mesajı";
$text['gallery'] = "Galeriye Bakınız";
$text['wasborn_male'] = "doğdu";    // same as $text['wasborn'] if no gender verb
$text['wasborn_female'] = "doğdu";  // same as $text['wasborn'] if no gender verb
$text['waschristened_male'] = "vaftiz edildi";  // same as $text['waschristened'] if no gender verb
$text['waschristened_female'] = "vaftiz edildi";  // same as $text['waschristened'] if no gender verb
$text['died_male'] = "vefat etti";  // same as $text['anddied'] of no gender verb
$text['died_female'] = "vefat etti";  // same as $text['anddied'] of no gender verb
$text['wasburied_male'] = "defnedildi";  // same as $text['wasburied'] if no gender verb
$text['wasburied_female'] = "defnedildi";  // same as $text['wasburied'] if no gender verb
$text['wascremated_male'] = "yakıldı";    // same as $text['wascremated'] if no gender verb
$text['wascremated_female'] = "yakıldı";  // same as $text['wascremated'] if no gender verb
$text['wasmarried_male'] = "evli";  // same as $text['wasmarried'] if no gender verb
$text['wasmarried_female'] = "evli";  // same as $text['wasmarried'] if no gender verb
$text['wasdivorced_male'] = "boşandı";  // might be the same as $text['divorce'] but as a verb
$text['wasdivorced_female'] = "boşandı";  // might be the same as $text['divorce'] but as a verb
$text['inplace'] = " . ";      // used as a preposition to the location
$text['onthisdate'] = " . ";    // when used with full date
$text['inthisyear'] = " . ";    // when used with year only or month / year dates
$text['and'] = "ve ";        // used in conjunction with wasburied or was cremated

//moved here in 12.3
$text['dna_info_head'] = "DNA Testi Bilgisi";
$text['firstpage'] = "İlk Sayfa";
$text['lastpage'] = "Son Sayfa";

@include_once("captcha_text.php");
@include_once("alltext.php");
if (!$alltextloaded) {
  getAllTextPath();
}
?>

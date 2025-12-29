<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'title' => 'Mesafeli Satış Sözleşmesi',
                'slug' => 'mesafeli-satis-sozlesmesi',
                'is_active' => true,
                'order' => 1,
                'content' => $this->getMesafeliSatisSozlesmesi(),
            ],
            [
                'title' => 'Gizlilik Politikası',
                'slug' => 'gizlilik-politikasi',
                'is_active' => true,
                'order' => 2,
                'content' => $this->getGizlilikPolitikasi(),
            ],
            [
                'title' => 'KVKK Aydınlatma Metni',
                'slug' => 'kvkk-aydinlatma-metni',
                'is_active' => true,
                'order' => 3,
                'content' => $this->getKvkkAydinlatmaMetni(),
            ],
            [
                'title' => 'Çerez Politikası',
                'slug' => 'cerez-politikasi',
                'is_active' => true,
                'order' => 4,
                'content' => $this->getCerezPolitikasi(),
            ],
            [
                'title' => 'Kullanım Koşulları',
                'slug' => 'kullanim-kosullari',
                'is_active' => true,
                'order' => 5,
                'content' => $this->getKullanimKosullari(),
            ],
            [
                'title' => 'İade ve Değişim Koşulları',
                'slug' => 'iade-degisim-kosullari',
                'is_active' => true,
                'order' => 6,
                'content' => $this->getIadeDegisimKosullari(),
            ],
            [
                'title' => 'Teslimat ve Kargo',
                'slug' => 'teslimat-kargo',
                'is_active' => true,
                'order' => 7,
                'content' => $this->getTeslimatKargo(),
            ],
            [
                'title' => 'Hakkımızda',
                'slug' => 'hakkimizda',
                'is_active' => true,
                'order' => 8,
                'content' => $this->getHakkimizda(),
            ],
            [
                'title' => 'İletişim',
                'slug' => 'iletisim',
                'is_active' => true,
                'order' => 9,
                'content' => $this->getIletisim(),
            ],
            [
                'title' => 'Sıkça Sorulan Sorular',
                'slug' => 'sikca-sorulan-sorular',
                'is_active' => true,
                'order' => 10,
                'content' => $this->getSikcaSorulanSorular(),
            ],
        ])->each(function ($data) {
            Page::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'is_active' => $data['is_active'],
                    'order' => $data['order'],
                ]
            );
        });
    }

    private function getMesafeliSatisSozlesmesi(): string
    {
        return <<<HTML
<h2>MESAFELİ SATIŞ SÖZLEŞMESİ</h2>

<h3>MADDE 1 - TARAFLAR</h3>
<p><strong>1.1 SATICI:</strong></p>
<ul>
    <li><strong>Ünvan:</strong> [ŞİRKET ADI]</li>
    <li><strong>Adres:</strong> [ŞİRKET ADRESİ]</li>
    <li><strong>Telefon:</strong> [TELEFON NUMARASI]</li>
    <li><strong>E-posta:</strong> [E-POSTA ADRESİ]</li>
    <li><strong>Mersis No:</strong> [MERSİS NUMARASI]</li>
</ul>

<p><strong>1.2 ALICI:</strong></p>
<p>Siteye üye olan ve sipariş veren kişidir. Alıcının iletişim bilgileri sipariş formunda yer almaktadır.</p>

<h3>MADDE 2 - KONU</h3>
<p>İşbu sözleşmenin konusu, Alıcı'nın Satıcı'ya ait web sitesinden elektronik ortamda sipariş verdiği, sözleşmede belirtilen niteliklere sahip ürünün satışı ve teslimi ile ilgili olarak 6502 Sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği hükümleri gereğince tarafların hak ve yükümlülüklerinin belirlenmesidir.</p>

<h3>MADDE 3 - SÖZLEŞME KONUSU ÜRÜN BİLGİLERİ</h3>
<p>Ürünün temel özellikleri, satış fiyatı ve ödeme şekli sipariş sayfasında yer almaktadır. Ürün/ürünlerin temel özelliklerini (türü, miktarı, renk, ağırlık vb.) sipariş onayı e-postasından ve fatura üzerinden görebilirsiniz.</p>

<h3>MADDE 4 - GENEL HÜKÜMLER</h3>
<p>4.1 Alıcı, Satıcı'ya ait web sitesinde sözleşme konusu ürünün temel nitelikleri, satış fiyatı ve ödeme şekli ile teslimata ilişkin ön bilgileri okuyup, bilgi sahibi olduğunu, elektronik ortamda gerekli teyidi verdiğini kabul, beyan ve taahhüt eder.</p>
<p>4.2 Sözleşme konusu her bir ürün, 30 günlük yasal süreyi aşmamak koşulu ile Alıcı'nın yerleşim yeri uzaklığına bağlı olarak satın alındığı tarihten itibaren 3-7 iş günü içinde Alıcı veya Alıcı'nın gösterdiği adresteki kişi ve/veya kuruluşa teslim edilir.</p>

<h3>MADDE 5 - CAYMA HAKKI</h3>
<p>5.1 Alıcı, sözleşme konusu ürünü teslim aldığı tarihten itibaren 14 (on dört) gün içinde herhangi bir gerekçe göstermeksizin ve cezai şart ödemeksizin cayma hakkına sahiptir.</p>
<p>5.2 Cayma hakkının kullanılması için bu süre içinde Satıcı'ya yazılı bildirimde bulunulması ve ürünün kullanılmamış olması gerekmektedir.</p>
<p>5.3 Cayma hakkının kullanılması halinde, ürün Satıcı'ya iade edilir ve ürün bedeli 14 gün içinde Alıcı'ya iade edilir.</p>

<h3>MADDE 6 - CAYMA HAKKININ KULLANILAMAYACAĞI HALLER</h3>
<p>Tüketicinin özel istekleri veya kişisel ihtiyaçları doğrultusunda hazırlanan, niteliği itibariyle geri gönderilmeye elverişli olmayan ve çabuk bozulma tehlikesi olan veya son kullanma tarihi geçme ihtimali olan ürünler cayma hakkı kapsamı dışındadır.</p>

<h3>MADDE 7 - YETKİLİ MAHKEME</h3>
<p>İşbu sözleşmeden doğan uyuşmazlıklarda şikayet ve itirazlar, aşağıdaki kanunda belirtilen parasal sınırlar dâhilinde tüketicinin yerleşim yerinin bulunduğu veya tüketici işleminin yapıldığı yerdeki tüketici sorunları hakem heyetine veya tüketici mahkemesine yapılacaktır.</p>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getGizlilikPolitikasi(): string
    {
        return <<<HTML
<h2>GİZLİLİK POLİTİKASI</h2>

<p>[ŞİRKET ADI] olarak, kullanıcılarımızın gizliliğini korumak en önemli önceliklerimizden biridir. Bu politika, hangi bilgileri topladığımızı, bu bilgileri nasıl kullandığımızı ve koruduğumuzu açıklamaktadır.</p>

<h3>1. TOPLANAN BİLGİLER</h3>
<p>Web sitemizi ziyaret ettiğinizde ve alışveriş yaptığınızda aşağıdaki bilgiler toplanabilir:</p>
<ul>
    <li>Ad, soyad ve iletişim bilgileri</li>
    <li>Teslimat ve fatura adresi</li>
    <li>E-posta adresi ve telefon numarası</li>
    <li>Ödeme bilgileri (güvenli ödeme sistemleri üzerinden)</li>
    <li>IP adresi ve tarayıcı bilgileri</li>
    <li>Çerez verileri</li>
</ul>

<h3>2. BİLGİLERİN KULLANIMI</h3>
<p>Toplanan bilgiler aşağıdaki amaçlarla kullanılır:</p>
<ul>
    <li>Siparişlerin işlenmesi ve teslimatı</li>
    <li>Müşteri hizmetleri ve destek sağlanması</li>
    <li>Ödeme işlemlerinin gerçekleştirilmesi</li>
    <li>Yasal yükümlülüklerin yerine getirilmesi</li>
    <li>Pazarlama iletişimleri (onay verilmesi halinde)</li>
</ul>

<h3>3. BİLGİLERİN PAYLAŞIMI</h3>
<p>Kişisel bilgileriniz, yasal zorunluluklar dışında üçüncü taraflarla paylaşılmaz. Ödeme ve kargo hizmetleri için zorunlu olan minimum bilgiler ilgili iş ortaklarıyla paylaşılabilir.</p>

<h3>4. GÜVENLİK</h3>
<p>Kişisel bilgileriniz, SSL sertifikası ve güvenli sunucular kullanılarak korunmaktadır. Ödeme işlemleriniz güvenli ödeme sistemleri üzerinden gerçekleştirilmektedir.</p>

<h3>5. HAKLARINIZ</h3>
<p>KVKK kapsamında aşağıdaki haklara sahipsiniz:</p>
<ul>
    <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
    <li>Kişisel verilerinize erişim talep etme</li>
    <li>Kişisel verilerinizin düzeltilmesini veya silinmesini talep etme</li>
    <li>İşlemenin kısıtlanmasını talep etme</li>
</ul>

<h3>6. İLETİŞİM</h3>
<p>Gizlilik politikamız hakkında sorularınız için [E-POSTA ADRESİ] adresinden bize ulaşabilirsiniz.</p>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getKvkkAydinlatmaMetni(): string
    {
        return <<<HTML
<h2>KİŞİSEL VERİLERİN KORUNMASI HAKKINDA AYDINLATMA METNİ</h2>

<p>[ŞİRKET ADI] olarak, 6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") kapsamında veri sorumlusu sıfatıyla, kişisel verilerinizi aşağıda açıklanan amaçlar ve hukuki sebepler doğrultusunda işlemekteyiz.</p>

<h3>1. VERİ SORUMLUSU</h3>
<p><strong>Ünvan:</strong> [ŞİRKET ADI]</p>
<p><strong>Adres:</strong> [ŞİRKET ADRESİ]</p>
<p><strong>E-posta:</strong> [E-POSTA ADRESİ]</p>

<h3>2. İŞLENEN KİŞİSEL VERİLER</h3>
<ul>
    <li><strong>Kimlik Bilgileri:</strong> Ad, soyad, T.C. kimlik numarası</li>
    <li><strong>İletişim Bilgileri:</strong> Telefon, e-posta, adres</li>
    <li><strong>Müşteri İşlem Bilgileri:</strong> Sipariş bilgileri, ödeme bilgileri</li>
    <li><strong>Dijital İz Bilgileri:</strong> IP adresi, çerez verileri, log kayıtları</li>
</ul>

<h3>3. KİŞİSEL VERİLERİN İŞLENME AMAÇLARI</h3>
<ul>
    <li>Ürün ve hizmet satış süreçlerinin yürütülmesi</li>
    <li>Sözleşmesel yükümlülüklerin yerine getirilmesi</li>
    <li>Müşteri ilişkileri yönetimi</li>
    <li>Fatura ve ödeme işlemlerinin gerçekleştirilmesi</li>
    <li>Kargo ve teslimat işlemlerinin yapılması</li>
    <li>Yasal yükümlülüklerin yerine getirilmesi</li>
    <li>İzin verilmesi halinde pazarlama faaliyetleri</li>
</ul>

<h3>4. KİŞİSEL VERİLERİN AKTARILMASI</h3>
<p>Kişisel verileriniz, yukarıda belirtilen amaçlarla:</p>
<ul>
    <li>Kargo şirketleri</li>
    <li>Ödeme kuruluşları</li>
    <li>Yetkili kamu kurum ve kuruluşları</li>
    <li>Hukuki danışmanlık hizmeti alınan firmalar</li>
</ul>
<p>ile paylaşılabilmektedir.</p>

<h3>5. KİŞİSEL VERİ TOPLAMA YÖNTEMİ VE HUKUKİ SEBEBİ</h3>
<p>Kişisel verileriniz; web sitemiz, e-posta, telefon ve fiziksel formlar aracılığıyla toplanmaktadır. Hukuki sebepler:</p>
<ul>
    <li>Sözleşmenin kurulması veya ifası</li>
    <li>Kanunlarda açıkça öngörülmesi</li>
    <li>Meşru menfaatlerimiz</li>
    <li>Açık rızanız (pazarlama için)</li>
</ul>

<h3>6. KVKK KAPSAMINDA HAKLARINIZ</h3>
<p>KVKK'nın 11. maddesi kapsamında:</p>
<ul>
    <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
    <li>İşlenmişse buna ilişkin bilgi talep etme</li>
    <li>İşlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme</li>
    <li>Yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri bilme</li>
    <li>Eksik veya yanlış işlenmişse düzeltilmesini isteme</li>
    <li>Silinmesini veya yok edilmesini isteme</li>
    <li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme</li>
    <li>Zarara uğramanız hâlinde zararın giderilmesini talep etme</li>
</ul>

<p>Haklarınızı kullanmak için [E-POSTA ADRESİ] adresine yazılı başvuru yapabilirsiniz.</p>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getCerezPolitikasi(): string
    {
        return <<<HTML
<h2>ÇEREZ POLİTİKASI</h2>

<p>[ŞİRKET ADI] olarak, web sitemizde çerezler (cookies) kullanmaktayız. Bu politika, çerezlerin ne olduğunu, nasıl kullandığımızı ve tercihlerinizi nasıl yönetebileceğinizi açıklamaktadır.</p>

<h3>1. ÇEREZ NEDİR?</h3>
<p>Çerezler, web sitelerinin bilgisayarınıza veya mobil cihazınıza yerleştirdiği küçük metin dosyalarıdır. Bu dosyalar, size daha iyi bir kullanıcı deneyimi sunmak için kullanılmaktadır.</p>

<h3>2. KULLANILAN ÇEREZ TÜRLERİ</h3>

<h4>2.1 Zorunlu Çerezler</h4>
<p>Web sitesinin düzgün çalışması için gerekli olan çerezlerdir. Sepet işlemleri, giriş yapma ve güvenlik özellikleri bu çerezlere bağlıdır.</p>

<h4>2.2 Performans Çerezleri</h4>
<p>Ziyaretçilerin siteyi nasıl kullandığını anlamamıza yardımcı olur. Google Analytics gibi araçlar bu amaçla kullanılmaktadır.</p>

<h4>2.3 İşlevsellik Çerezleri</h4>
<p>Tercihlerinizi (dil, para birimi vb.) hatırlayarak daha kişiselleştirilmiş bir deneyim sunar.</p>

<h4>2.4 Pazarlama Çerezleri</h4>
<p>İlgi alanlarınıza uygun reklamlar göstermek için kullanılır. Üçüncü taraf hizmet sağlayıcılar tarafından yerleştirilebilir.</p>

<h3>3. ÇEREZ TERCİHLERİNİZ</h3>
<p>Tarayıcınızın ayarlarından çerezleri yönetebilir veya silebilirsiniz. Ancak bazı çerezleri devre dışı bırakmanız, site işlevselliğini etkileyebilir.</p>

<h4>Tarayıcı Ayarları:</h4>
<ul>
    <li><strong>Chrome:</strong> Ayarlar → Gizlilik ve güvenlik → Çerezler</li>
    <li><strong>Firefox:</strong> Tercihler → Gizlilik ve Güvenlik → Çerezler</li>
    <li><strong>Safari:</strong> Tercihler → Gizlilik → Çerezler</li>
    <li><strong>Edge:</strong> Ayarlar → Çerezler ve site izinleri</li>
</ul>

<h3>4. ÜÇÜNCÜ TARAF ÇEREZLERİ</h3>
<p>Web sitemizde aşağıdaki üçüncü taraf hizmetleri kullanılmaktadır:</p>
<ul>
    <li>Google Analytics (analiz)</li>
    <li>Facebook Pixel (pazarlama)</li>
    <li>Ödeme sistemleri (güvenlik)</li>
</ul>

<h3>5. İLETİŞİM</h3>
<p>Çerez politikamız hakkında sorularınız için [E-POSTA ADRESİ] adresinden bize ulaşabilirsiniz.</p>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getKullanimKosullari(): string
    {
        return <<<HTML
<h2>KULLANIM KOŞULLARI</h2>

<p>[ŞİRKET ADI] web sitesini kullanarak aşağıdaki koşulları kabul etmiş sayılırsınız. Lütfen bu koşulları dikkatlice okuyunuz.</p>

<h3>1. GENEL HÜKÜMLER</h3>
<p>Bu web sitesi [ŞİRKET ADI] tarafından işletilmektedir. Site, Türkiye Cumhuriyeti kanunlarına tabidir.</p>

<h3>2. SİTE KULLANIMI</h3>
<ul>
    <li>Siteyi yalnızca yasal amaçlarla kullanabilirsiniz</li>
    <li>Siteye zarar verecek faaliyetlerde bulunamazsınız</li>
    <li>Başkalarının haklarını ihlal edemezsiniz</li>
    <li>Yanlış veya yanıltıcı bilgi sağlayamazsınız</li>
</ul>

<h3>3. ÜYELİK</h3>
<p>3.1 Üyelik için 18 yaşından büyük olmanız gerekmektedir.</p>
<p>3.2 Üyelik bilgilerinizin gizliliğinden siz sorumlusunuz.</p>
<p>3.3 Hesabınızda gerçekleşen tüm işlemlerden siz sorumlusunuz.</p>

<h3>4. SİPARİŞ VE ÖDEME</h3>
<p>4.1 Sipariş vermekle, ürün bedelini ödemeyi kabul etmiş olursunuz.</p>
<p>4.2 Fiyatlar önceden haber verilmeksizin değiştirilebilir.</p>
<p>4.3 Stok durumuna göre siparişler iptal edilebilir.</p>

<h3>5. FİKRİ MÜLKİYET HAKLARI</h3>
<p>Sitedeki tüm içerik (metin, görsel, logo, tasarım vb.) [ŞİRKET ADI]'na aittir ve telif hakları ile korunmaktadır. İzinsiz kullanım yasaktır.</p>

<h3>6. SORUMLULUK SINIRI</h3>
<p>[ŞİRKET ADI], site kullanımından kaynaklanan doğrudan veya dolaylı zararlardan sorumlu tutulamaz.</p>

<h3>7. DEĞİŞİKLİKLER</h3>
<p>Bu kullanım koşulları önceden haber verilmeksizin değiştirilebilir. Değişiklikler sitede yayınlandığı anda yürürlüğe girer.</p>

<h3>8. YETKİLİ MAHKEME</h3>
<p>Bu koşullardan doğan uyuşmazlıklarda [ŞEHİR] Mahkemeleri ve İcra Daireleri yetkilidir.</p>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getIadeDegisimKosullari(): string
    {
        return <<<HTML
<h2>İADE VE DEĞİŞİM KOŞULLARI</h2>

<p>[ŞİRKET ADI] olarak müşteri memnuniyeti bizim için çok önemlidir. Aşağıdaki koşullar çerçevesinde iade ve değişim işlemlerinizi gerçekleştirebilirsiniz.</p>

<h3>1. CAYMA HAKKI</h3>
<p>6502 sayılı Tüketicinin Korunması Hakkında Kanun gereğince, ürünü teslim aldığınız tarihten itibaren <strong>14 (on dört) gün</strong> içinde cayma hakkınızı kullanabilirsiniz.</p>

<h3>2. İADE KOŞULLARI</h3>
<p>İade için aşağıdaki koşulların sağlanması gerekmektedir:</p>
<ul>
    <li>Ürün kullanılmamış ve orijinal ambalajında olmalıdır</li>
    <li>Ürün etiketi/bandı sökülmemiş olmalıdır</li>
    <li>Fatura aslı iade ile birlikte gönderilmelidir</li>
    <li>Ürün, teslim aldığınız şekliyle iade edilmelidir</li>
</ul>

<h3>3. İADE SÜRECİ</h3>
<ol>
    <li>[E-POSTA ADRESİ] adresine iade talebinizi bildirin</li>
    <li>İade formunu doldurun (e-posta ile gönderilecektir)</li>
    <li>Ürünü orijinal ambalajında, fatura ile birlikte kargoya verin</li>
    <li>Ürün tarafımıza ulaştıktan sonra kontrol edilir</li>
    <li>Onay sonrası 14 gün içinde ödemeniz iade edilir</li>
</ol>

<h3>4. KARGO ÜCRETİ</h3>
<p>İade kargo ücreti:</p>
<ul>
    <li><strong>Cayma hakkı kullanımında:</strong> Alıcıya aittir</li>
    <li><strong>Hatalı/hasarlı ürün iadesinde:</strong> [ŞİRKET ADI]'na aittir</li>
</ul>

<h3>5. DEĞİŞİM</h3>
<p>Ürün değişimi için yukarıdaki iade koşulları geçerlidir. Değişim talebinizi belirterek bize ulaşabilirsiniz.</p>

<h3>6. İADE EDİLEMEYEN ÜRÜNLER</h3>
<p>Aşağıdaki ürünler iade edilemez:</p>
<ul>
    <li>Kişiye özel hazırlanan ürünler (isim yazılı kolyeler vb.)</li>
    <li>Kullanılmış veya ambalajı açılmış ürünler</li>
    <li>Hijyen gereklilikleri nedeniyle iade edilemeyen ürünler</li>
</ul>

<h3>7. ÖDEME İADESİ</h3>
<p>İade onaylandıktan sonra:</p>
<ul>
    <li><strong>Kredi kartı ile ödeme:</strong> Kartınıza 14 gün içinde iade edilir</li>
    <li><strong>Havale/EFT ile ödeme:</strong> Banka hesabınıza 14 gün içinde iade edilir</li>
</ul>

<h3>8. İLETİŞİM</h3>
<p>İade ve değişim işlemleriniz için:</p>
<ul>
    <li><strong>E-posta:</strong> [E-POSTA ADRESİ]</li>
    <li><strong>Telefon:</strong> [TELEFON NUMARASI]</li>
</ul>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getTeslimatKargo(): string
    {
        return <<<HTML
<h2>TESLİMAT VE KARGO BİLGİLERİ</h2>

<p>[ŞİRKET ADI] olarak siparişlerinizi en hızlı ve güvenli şekilde size ulaştırmayı hedefliyoruz.</p>

<h3>1. TESLİMAT SÜRESİ</h3>
<ul>
    <li><strong>Stokta olan ürünler:</strong> 1-3 iş günü içinde kargoya verilir</li>
    <li><strong>Özel üretim ürünler:</strong> 5-7 iş günü içinde kargoya verilir</li>
    <li><strong>Teslimat süresi:</strong> Kargoya verildikten sonra 1-3 iş günü (şehre göre değişir)</li>
</ul>

<h3>2. KARGO FİRMALARI</h3>
<p>Siparişleriniz aşağıdaki anlaşmalı kargo firmalarımız ile gönderilmektedir:</p>
<ul>
    <li>Yurtiçi Kargo</li>
    <li>Aras Kargo</li>
    <li>MNG Kargo</li>
</ul>

<h3>3. KARGO ÜCRETİ</h3>
<ul>
    <li><strong>500 TL ve üzeri siparişlerde:</strong> Ücretsiz kargo</li>
    <li><strong>500 TL altı siparişlerde:</strong> 49,90 TL kargo ücreti</li>
</ul>

<h3>4. KARGO TAKİBİ</h3>
<p>Siparişiniz kargoya verildiğinde, kargo takip numarası SMS ve e-posta ile tarafınıza iletilecektir. Bu numara ile kargo firmasının web sitesinden siparişinizi takip edebilirsiniz.</p>

<h3>5. TESLİMAT</h3>
<ul>
    <li>Teslimat, belirttiğiniz adrese yapılacaktır</li>
    <li>Teslimat sırasında kimlik ibrazı istenebilir</li>
    <li>İmza karşılığı teslimat yapılmaktadır</li>
    <li>Adresinizde bulunmamanız halinde kargo şubeden teslim alınabilir</li>
</ul>

<h3>6. HASARLI TESLİMAT</h3>
<p>Kargo teslimi sırasında:</p>
<ol>
    <li>Paketi kontrol edin</li>
    <li>Hasar varsa tutanak tutturun</li>
    <li>Hasarlı ürün fotoğraflarını çekin</li>
    <li>24 saat içinde bize bildirin</li>
</ol>

<h3>7. TESLİMAT YAPILAMAMASI</h3>
<p>Teslimat yapılamaması durumunda:</p>
<ul>
    <li>Kargo şubesinde 3 gün bekletilir</li>
    <li>3 gün içinde alınmazsa iade edilir</li>
    <li>Tekrar gönderim için ek kargo ücreti talep edilebilir</li>
</ul>

<h3>8. İLETİŞİM</h3>
<p>Kargo ve teslimat ile ilgili sorularınız için:</p>
<ul>
    <li><strong>E-posta:</strong> [E-POSTA ADRESİ]</li>
    <li><strong>Telefon:</strong> [TELEFON NUMARASI]</li>
</ul>

<p><em>Son Güncelleme: [TARİH]</em></p>
HTML;
    }

    private function getHakkimizda(): string
    {
        return <<<HTML
<h2>HAKKIMIZDA</h2>

<p><strong>[ŞİRKET ADI]</strong> ailesi olarak, sizlere en kaliteli gümüş takıları sunmak için buradayız.</p>

<h3>HİKAYEMİZ</h3>
<p>Yılların tecrübesiyle, geleneksel el işçiliğini modern tasarımlarla birleştirerek sizlere benzersiz gümüş takılar sunuyoruz. Her bir parçamız, ustalıkla işlenmiş 925 ayar gümüşten üretilmektedir.</p>

<h3>MİSYONUMUZ</h3>
<p>Müşterilerimize en kaliteli gümüş takıları, uygun fiyatlarla ve mükemmel müşteri hizmeti ile sunmak. Her kadının ve erkeğin kendini özel hissetmesini sağlayacak takılar tasarlamak.</p>

<h3>VİZYONUMUZ</h3>
<p>Türkiye'nin önde gelen online gümüş takı markası olmak ve dünya genelinde tanınan bir marka haline gelmek.</p>

<h3>DEĞERLERİMİZ</h3>
<ul>
    <li><strong>Kalite:</strong> 925 ayar saf gümüş kullanımı</li>
    <li><strong>Özgünlük:</strong> El işçiliği ve benzersiz tasarımlar</li>
    <li><strong>Güven:</strong> Müşteri memnuniyeti odaklı hizmet</li>
    <li><strong>Şeffaflık:</strong> Dürüst fiyatlandırma ve açık iletişim</li>
</ul>

<h3>NEDEN BİZ?</h3>
<ul>
    <li>✓ %100 925 ayar gümüş garantisi</li>
    <li>✓ 14 gün koşulsuz iade hakkı</li>
    <li>✓ Ücretsiz kargo (500 TL üzeri)</li>
    <li>✓ Güvenli ödeme seçenekleri</li>
    <li>✓ 7/24 müşteri desteği</li>
</ul>

<h3>SERTİFİKALARIMIZ</h3>
<p>Tüm ürünlerimiz, 925 ayar gümüş sertifikasına sahiptir ve kalite kontrol süreçlerinden geçirilmektedir.</p>

<p><em>[ŞİRKET ADI] ailesine hoş geldiniz!</em></p>
HTML;
    }

    private function getIletisim(): string
    {
        return <<<HTML
<h2>İLETİŞİM</h2>

<p>Bizimle iletişime geçmek için aşağıdaki kanalları kullanabilirsiniz. En kısa sürede size dönüş yapacağız.</p>

<h3>İLETİŞİM BİLGİLERİ</h3>

<h4>📍 Adres</h4>
<p>[ŞİRKET ADRESİ]<br>
[İLÇE] / [ŞEHİR]</p>

<h4>📞 Telefon</h4>
<p>[TELEFON NUMARASI]</p>

<h4>📧 E-posta</h4>
<p><strong>Genel Sorular:</strong> [GENEL E-POSTA]</p>
<p><strong>Sipariş Takibi:</strong> [SİPARİŞ E-POSTA]</p>
<p><strong>İade ve Değişim:</strong> [İADE E-POSTA]</p>

<h4>⏰ Çalışma Saatleri</h4>
<p><strong>Pazartesi - Cumartesi:</strong> 09:00 - 18:00<br>
<strong>Pazar:</strong> Kapalı</p>

<h3>SOSYAL MEDYA</h3>
<p>Bizi sosyal medyada takip edin:</p>
<ul>
    <li><strong>Instagram:</strong> @[INSTAGRAM]</li>
    <li><strong>Facebook:</strong> /[FACEBOOK]</li>
    <li><strong>Twitter:</strong> @[TWITTER]</li>
</ul>

<h3>SIKÇA SORULAN SORULAR</h3>
<p>Birçok sorunuzun cevabını <a href="/sikca-sorulan-sorular">Sıkça Sorulan Sorular</a> sayfamızda bulabilirsiniz.</p>

<h3>GERİ BİLDİRİM</h3>
<p>Görüş ve önerileriniz bizim için çok değerli. Deneyimlerinizi bizimle paylaşın, daha iyi hizmet sunmamıza yardımcı olun.</p>

<p><em>Size yardımcı olmaktan mutluluk duyarız!</em></p>
HTML;
    }

    private function getSikcaSorulanSorular(): string
    {
        return <<<HTML
<h2>SIKÇA SORULAN SORULAR</h2>

<h3>SİPARİŞ VE ÖDEME</h3>

<h4>Nasıl sipariş verebilirim?</h4>
<p>Beğendiğiniz ürünü sepete ekleyin, üye girişi yapın veya misafir olarak devam edin, teslimat ve ödeme bilgilerinizi girerek siparişinizi tamamlayın.</p>

<h4>Hangi ödeme yöntemlerini kabul ediyorsunuz?</h4>
<p>Kredi kartı (tüm bankalar), banka kartı, havale/EFT ve kapıda ödeme seçeneklerimiz mevcuttur.</p>

<h4>Taksit seçeneği var mı?</h4>
<p>Evet, tüm kredi kartlarına vade farksız 3 taksit imkanı sunuyoruz. Bazı bankalarda 6 taksite kadar seçenek mevcuttur.</p>

<h4>Siparişimi nasıl takip edebilirim?</h4>
<p>Hesabım → Siparişlerim bölümünden veya size gönderilen kargo takip numarası ile kargo firmasının sitesinden takip edebilirsiniz.</p>

<h3>KARGO VE TESLİMAT</h3>

<h4>Kargo ücreti ne kadar?</h4>
<p>500 TL ve üzeri siparişlerde kargo ücretsizdir. Altındaki siparişlerde 49,90 TL kargo ücreti uygulanır.</p>

<h4>Teslimat ne kadar sürer?</h4>
<p>Stokta olan ürünler 1-3 iş günü içinde kargoya verilir. Kargoya verildikten sonra 1-3 iş günü içinde adresinize ulaşır.</p>

<h4>Aynı gün kargo mümkün mü?</h4>
<p>Saat 14:00'a kadar verilen siparişler aynı gün kargoya verilir.</p>

<h3>İADE VE DEĞİŞİM</h3>

<h4>İade hakkım var mı?</h4>
<p>Evet, ürünü teslim aldığınız tarihten itibaren 14 gün içinde iade edebilirsiniz.</p>

<h4>İade için ne yapmalıyım?</h4>
<p>Müşteri hizmetlerimizi arayın veya e-posta gönderin. İade süreci hakkında bilgilendirileceksiniz.</p>

<h4>Param ne zaman iade edilir?</h4>
<p>Ürün tarafımıza ulaşıp kontrol edildikten sonra 14 gün içinde ödemeniz iade edilir.</p>

<h3>ÜRÜNLER</h3>

<h4>Ürünleriniz gerçek gümüş mü?</h4>
<p>Evet, tüm ürünlerimiz 925 ayar (sterling silver) saf gümüştür ve sertifikalıdır.</p>

<h4>Gümüş kararır mı?</h4>
<p>Gümüş doğası gereği zamanla oksitlenebilir. Düzenli temizlik ve doğru saklama ile parlaklığını koruyabilirsiniz.</p>

<h4>Beden/boyut değişikliği yapılabilir mi?</h4>
<p>Yüzük beden ayarı ücretsiz olarak yapılmaktadır. Diğer ürünler için müşteri hizmetlerimizle iletişime geçin.</p>

<h3>HESAP</h3>

<h4>Şifremi unuttum, ne yapmalıyım?</h4>
<p>Giriş sayfasındaki "Şifremi Unuttum" bağlantısına tıklayın. E-posta adresinize şifre sıfırlama linki gönderilecektir.</p>

<h4>Hesap bilgilerimi nasıl güncellerim?</h4>
<p>Hesabım → Profil Bilgilerim bölümünden tüm bilgilerinizi güncelleyebilirsiniz.</p>

<p><em>Başka sorularınız mı var? <a href="/iletisim">İletişim sayfamızdan</a> bize ulaşın!</em></p>
HTML;
    }
}

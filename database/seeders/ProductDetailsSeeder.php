<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductDetailsSeeder extends Seeder
{
    public function run(): void
    {
        // 🩷 Hello Kitty 
        Product::where('image_url', 'collection/kitty/kitty2.png')->update([
            'description' => 'Exclusive Monchhichi collaboration plush featuring Hello Kitty hat, bright red bow, and blue jumpsuit with adorable charm.',
            'size_cm' => '20 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty3.png')->update([
            'description' => 'Set of two Hello Kitty mini figurines — one in her signature blue outfit and the other in pink, showcasing her sweet and playful expressions.',
            'size_cm' => '10 cm each',
        ]);

        Product::where('image_url', 'collection/kitty/kitty4.png')->update([
            'description' => 'Festive Hello Kitty plush wearing a red-and-white striped dress with sparkling sequin bow and matching hat — perfect for holiday decor.',
            'size_cm' => '19 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty5.png')->update([
            'description' => 'Sweet Hello Kitty figurine dressed as a strawberry, holding a small fruit basket — a perfect blend of cuteness and charm.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty6.png')->update([
            'description' => 'Soft square Hello Kitty plush in a fluffy brown bear costume with a red bow — cute and collectible design.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty7.png')->update([
            'description' => 'Hello Kitty with baby kitty figurine, showcasing a tender moment between the iconic character and her little companion.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty8.png')->update([
            'description' => 'Hello Kitty figurine holding a shiny red apple, dressed in her classic blue overalls and red bow — a timeless design.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty9.png')->update([
            'description' => 'Hello Kitty figurine enjoying a tea party, complete with a detailed tea set and her signature red bow.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty10.png')->update([
            'description' => 'Hello Kitty picnic figurine set, featuring her in a cute outfit with a picnic basket and blanket, perfect for outdoor fun scenes.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty11.png')->update([
            'description' => 'Charming Hello Kitty figurine in sitting pose wearing her classic red outfit and shiny pink bow.',
            'size_cm' => '14 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty12.png')->update([
            'description' => 'Glossy Hello Kitty figurine in a red dress with signature bow, perfect for display or gifting.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty13.png')->update([
            'description' => 'Cute Hello Kitty plush in a red polka-dot dress with matching bow, bringing classic charm to your collection.',
            'size_cm' => '18 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty14.png')->update([
            'description' => 'Traditional Hello Kitty plush wearing blue overalls and red bow, capturing her timeless original look.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty15.png')->update([
            'description' => 'Fluffy pastel pink Hello Kitty plush with cherry blossom details and satin bow, inspired by springtime sakura.',
            'size_cm' => '18 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty16.png')->update([
            'description' => 'Unique Hello Kitty plush in a black cat costume with orange bow and ears, designed for a playful Halloween look.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty17.png')->update([
            'description' => 'Soft and fluffy Hello Kitty plush wearing a brown fuzzy outfit with a pale pink bow, perfect for a cozy collection.',
            'size_cm' => '14 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty18.png')->update([
            'description' => 'Fluffy Hello Kitty dressed in a cozy brown bear suit with a bright red bow and cute paw details.',
            'size_cm' => '20 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty19.png')->update([
            'description' => 'Adorable Hello Kitty plush dressed with a soft pink velvet bow and matching ribbon, detailed with a small pearl accent.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty20.png')->update([
            'description' => 'Elegant white Hello Kitty plush wearing a pearl necklace with a silver key charm and pink lace bow.',
            'size_cm' => '18 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty21.png')->update([
            'description' => 'Chic Hello Kitty plush wearing an elegant pink floral dress with black satin ribbon, pearl necklace, and matching hat accent — inspired by Parisian fashion.',
            'size_cm' => '20 cm',
        ]);

        // 💖 My Melody
        Product::where('image_url', 'collection/mymelody/mymelody2.png')->update([
            'description' => 'A delightful My Melody figure sitting atop a pink-drizzled dessert base, celebrating with a small birthday cake.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody3.png')->update([
            'description' => 'My Melody enjoying a lovely outdoor picnic with her friend, Flat the mouse, featuring a flower crown and picnic basket.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody4.png')->update([
            'description' => 'A charming figurine of My Melody wearing a detailed, lacy pink Lolita-style dress, perfect for display.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody5.png')->update([
            'description' => 'A unique My Melody plush with a functional pouch, dressed in a sweet blue and brown chocolate-themed outfit.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody6.png')->update([
            'description' => 'A spooky-cute My Melody keychain plush in a black lace gothic dress with pumpkin accents. Perfect for Halloween.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody7.png')->update([
            'description' => 'My Melody disguised in an extremely fuzzy, sherpa-style pink bear costume with a cute bow. Super soft texture.',
            'size_cm' => '22 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody8.png')->update([
            'description' => 'A compact and sweet mini plush keychain of My Melody in a simple pink bow tie, perfect for bags or keys.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody9.png')->update([
            'description' => 'An adorable large plush featuring My Melody sweetly hugging a tiny My Sweet Piano mini plush doll.',
            'size_cm' => '25 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody10.png')->update([
            'description' => 'My Melody riding a sweet pink bunny on a colorful cake stand base, holding a striped bunny-shaped balloon.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody11.png')->update([
            'description' => 'The essential My Melody plushie in her signature pink hood and a charming white flower accent. Soft and huggable.',
            'size_cm' => '20 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody12.png')->update([
            'description' => 'A medium plush of My Melody dressed in a pink gingham jumpsuit and matching beret with a small bunny head pin.',
            'size_cm' => '23 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody13.png')->update([
            'description' => 'A sweet My Melody figure standing in a praying/pleading pose, adorned with a classic sky blue bow.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody14.png')->update([
            'description' => 'My Melody dressed professionally in a nurse uniform with a heart-cap and stethoscope, standing on a pink heart base.',
            'size_cm' => '11 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody15.png')->update([
            'description' => 'An articulated My Melody figure in classic form with a white flower, holding a pink swirl lollipop accessory.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody16.png')->update([
            'description' => 'My Melody wearing an elegant Victorian-style ruffled dress and bonnet with pink roses, standing on a heart base.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody17.png')->update([
            'description' => 'My Melody in a large yellow bonnet with pastel bows, holding a basket filled with Easter eggs and chicks.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody18.png')->update([
            'description' => 'A cute figure of My Melody in a blue polka-dot dress with a large bow, hugging a tiny pink bunny plush.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody19.png')->update([
            'description' => 'A charming small figure of My Melody in a deep pink dress with heart-shaped pockets and a dotted pattern.',
            'size_cm' => '7 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody20.png')->update([
            'description' => 'A compact figure of My Melody dressed in pink florals, featuring a lovely rose garland crown and a small bouquet.',
            'size_cm' => '7 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody21.png')->update([
            'description' => 'A premium figure with glitter accents, My Melody is dressed in a lavish blue and pink gown, holding a tiny teapot.',
            'size_cm' => '14 cm',
        ]);

        // 🖤 Kuromi
        Product::where('image_url', 'collection/kuromi/kuromi2.png')->update([
            'description' => 'Kuromi sitting on a purple-dripped dessert base, holding a tiny cupcake to celebrate.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi3.png')->update([
            'description' => 'A classic Kuromi figure in her signature purple hood with a pink skull, holding a large pink and black heart.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi4.png')->update([
            'description' => 'An ornate Kuromi figure in a complex black and white gothic dress with purple bat accents and a fancy hat.',
            'size_cm' => '11 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi5.png')->update([
            'description' => 'Kuromi figure relaxing on a pink park bench with My Melody sitting beside her, capturing a sweet moment.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi6.png')->update([
            'description' => 'Kuromi with sheer angel wings and a pink tutu skirt, holding a clear heart and standing on a pink cloud base.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi7.png')->update([
            'description' => 'A ceramic-style figure of Kuromi as a witch with a purple hat, riding on a spooky-cute lavender dog figure.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi8.png')->update([
            'description' => 'A soft mini plush keychain with a unique brown fur texture, dressed in a purple polka-dot outfit and a flower clip.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi9.png')->update([
            'description' => 'A larger plush of Kuromi in a unique lavender color, wearing a bright pink skirt and a festive pumpkin hat.',
            'size_cm' => '20 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi10.png')->update([
            'description' => 'A small plush keychain of Kuromi in a black and vibrant purple lace dress, perfect for clipping onto bags.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi11.png')->update([
            'description' => 'A figure of Kuromi in a dark purple hood decorated with delicate pink roses and mint green ribbon accents.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi12.png')->update([
            'description' => 'A regal Kuromi figure wearing a pink and gold crown, holding a decorative gold skeleton key pendant.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi13.png')->update([
            'description' => 'A sitting Kuromi figure in purple, holding a large, pastel purple swirl lollipop, with a starry hair bow.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi14.png')->update([
            'description' => 'A cute figure of Kuromi winking, wearing a purple striped bow and holding a tiny pink accessory.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi15.png')->update([
            'description' => 'An incredibly soft and large plush of Kuromi dressed in a sherpa-style purple and white bear costume.',
            'size_cm' => '24 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi16.png')->update([
            'description' => 'The classic Kuromi figure standing on a pink pedestal base with her name. Simple and iconic.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi17.png')->update([
            'description' => 'Kuromi plush dressed in a pink and grey school uniform with a striped bow, carrying a matching small school bag.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi18.png')->update([
            'description' => 'A super fluffy Kuromi plush with a dark grey fuzzy hood and a sweet lavender ruffled collar and skirt.',
            'size_cm' => '22 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi19.png')->update([
            'description' => 'A plush of Kuromi in a beautiful black and purple polka-dot tulle dress with a matching hair bow.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi20.png')->update([
            'description' => '$530.0$A soft Kuromi plush in a dramatic grey hood, wearing a striking red dress with black and lace trim.',
            'size_cm' => '18 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi21.png')->update([
            'description' => 'A premium figure with glitter elements, Kuromi holds a bowl of a mysterious glowing green potion.',
            'size_cm' => '11 cm',
        ]);


        // 🩵 Hirono
        Product::where('image_url', 'collection/hirono/hirono2.png')->update([
            'description' => 'Hirono in a red hoodie and striped socks, looking sullen with a small, red devil-horned cat sitting on his head.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono3.png')->update([
            'description' => 'Hirono in overalls with a clear plastic bag over his head, holding a net with a small captured star inside..',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono4.png')->update([
            'description' => 'Hirono dressed as the Little Prince, gently holding the classic rose under a glass dome on a moon-like pedestal.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono5.png')->update([
            'description' => 'Hirono figure in boxing shorts and glove, wearing a cardboard Home box helmet. Comes with a branded box.',
            'size_cm' => '11 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono6.png')->update([
            'description' => 'A detailed vignette of Hirono sitting and playing an aged, distressed black grand piano.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono7.png')->update([
            'description' => 'Hirono wearing a fluffy brown bear suit and denim overalls, holding a brightly burning torch accessory.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono8.png')->update([
            'description' => 'A stylish accessory featuring rope and chains, a metal Hirono charm, and a large leather origami crane cutout.',
            'size_cm' => '25 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono9.png')->update([
            'description' => 'A small, functional backpack-shaped clip-on pouch featuring a patch of Hirono dressed in a frog costume.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono10.png')->update([
            'description' => 'Hirono as the Little Prince, cradling the rose-in-glass with a slightly different pose and base color.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono11.png')->update([
            'description' => 'A highly detailed plush of Hirono in a tattered, patched bunny costume with button eyes and a bleeding carrot.',
            'size_cm' => '20 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono12.png')->update([
            'description' => 'Hirono dressed in a clown mask and orange overalls, holding a bright red balloon with a melancholic expression..',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono13.png')->update([
            'description' => 'Hirono sitting in an old metal bucket with a small melting ghost figure dripping off his head.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono14.png')->update([
            'description' => 'Hirono sitting on a stool with a whimsical, long-limbed black and red puppet figure standing behind him.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono15.png')->update([
            'description' => 'Hirono as a playful king in a star-spangled cloak and a cardboard crown, holding a golden staff.',
            'size_cm' => '11 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono16.png')->update([
            'description' => 'Hirono as a focused scholar with large glasses, reading a book while balancing a stack of books and a hat on his head.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono17.png')->update([
            'description' => 'Hirono in a full red rose head costume, holding a thorny vine and standing on a rocky base.',
            'size_cm' => '11 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono18.png')->update([
            'description' => 'Hirono in a monkey suit, crying a tear while holding a banana to his ear and a yellow rotary phone.',
            'size_cm' => '10 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono19.png')->update([
            'description' => 'Hirono sitting with his arms crossed, wearing a cozy winter knit hat, next to a small green dinosaur companion.',
            'size_cm' => '8 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono20.png')->update([
            'description' => 'Hirono as a rustic scarecrow with a straw hat and patched clothes, balancing a small black crow on his arm.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono21.png')->update([
            'description' => 'Hirono piloting a metallic, futuristic vehicle, wearing a distressed metal pilot helmet. Highly detailed.',
            'size_cm' => '10 cm',
        ]);


        // 🌟 Twinkle
        Product::where('image_url', 'collection/twinkle/twinkle2.png')->update([
            'description' => 'A figure dressed as a fluffy bun/bear drizzled with chocolate, holding a lucky gold coin and topped with a cherry.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle3.png')->update([
            'description' => 'A plush, round bag charm with blue eyes, covered in brown shag fur, attached to a golden star ring.',
            'size_cm' => '9 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle4.png')->update([
            'description' => 'A figure in a yellow jumpsuit, red and white striped scarf, and oversized "Big Hug" mittens, offering a warm embrace.',
            'size_cm' => '11 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle5.png')->update([
            'description' => 'A solemn figure with scattered tattoos, sitting and reading a "LOST" map, with a small broken accessory nearby.',
            'size_cm' => '10 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle6.png')->update([
            'description' => 'A cheerful figure in a fuzzy bee costume, holding a honey dipper and a key, standing on a stack of honey-drizzled pancakes.',
            'size_cm' => '10 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle7.png')->update([
            'description' => 'A figure wearing a fluffy striped nightcap, holding a glowing star that reads "Nighty Night." Functions as a small lamp.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle8.png')->update([
            'description' => 'A decorative pin/brooch of the character in a blue/white harlequin outfit and a large bow, on a heart background.',
            'size_cm' => '7 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle9.png')->update([
            'description' => 'A dangly plush charm wearing a "Keep Shining" shirt and a yellow hooded outfit with striped stockings.',
            'size_cm' => '15 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle10.png')->update([
            'description' => 'A collectible diorama box featuring a little dreamer sailing on a crescent moon through a beautiful night sky.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle11.png')->update([
            'description' => 'A fuzzy, yellow plush keychain with a sweet smiling face and a star-shaped pom-pom attached.',
            'size_cm' => '12 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle12.png')->update([
            'description' => 'A figure designed as a black pepper sauce bottle, dressed in a dark suit with a "Black Pepper" label.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle13.png')->update([
            'description' => 'A figure designed as a blueberry sauce bottle, wearing a purple suit and a matching blueberry label.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle14.png')->update([
            'description' => 'A figure designed as a ketchup or chili sauce bottle, dressed in a red and cream suit with a red pointed hat.',
            'size_cm' => '9 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle15.png')->update([
            'description' => 'A large figure in a yellow suit with alarm bells on its hood, holding a functional or decorative clock.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle16.png')->update([
            'description' => 'A yellow fuzzy plush keychain holding a tiny blue book, perfect for literary fans.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle17.png')->update([
            'description' => 'A fuzzy plush keychain with a cheerful sun flower face ruff, representing a bright, sunny day.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle18.png')->update([
            'description' => 'A yellow plush keychain featuring a small clock face patch on its belly and red alarm bells on the hood.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle19.png')->update([
            'description' => 'A soft, light green plush keychain dressed in an adorable dinosaur costume with tiny white teeth detail.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle20.png')->update([
            'description' => 'A fluffy plush keychain with a pancake hat topped with a star of butter, holding a small wooden stirrer.',
            'size_cm' => '14 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle21.png')->update([
            'description' => 'A detailed vignette of the character in a blue coat, reading a letter next to a spotted red mailbox with a star topper.',
            'size_cm' => '14 cm',
        ]);
    }
}

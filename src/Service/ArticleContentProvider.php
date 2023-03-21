<?php

namespace App\Service;

use Demontpx\ParsedownBundle\Parsedown;

class ArticleContentProvider extends Parsedown implements \ArticleContentProviderInterface
{
    public $paragraph = [
        'Lorem Lorem ipsum **кофе** dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt [Фронтенд Абсолютович](/)
ut labore et dolore magna aliqua. Purus viverra accumsan in nisl. Diam vulputate ut pharetra sit amet aliquam. Faucibus a pellentesque sit amet
porttitor eget dolor morbi non. Est ultricies integer quis auctor elit sed. Tristique nulla aliquet enim tortor at. Tristique et egestas quis ipsum.
Consequat semper viverra nam libero. Lectus quam id leo in vitae turpis. In eu mi bibendum neque egestas congue quisque egestas diam. кофе blandit
turpis cursus in hac habitasse platea dictumst quisque.',

'Ullamcorper [malesuada](/) proin libero nunc consequat interdum varius sit amet. Odio pellentesque diam volutpat commodo sed egestas. Eget nunc
lobortis mattis aliquam. Cursus vitae congue mauris rhoncus aenean vel. Pretium viverra suspendisse potenti nullam ac tortor vitae. A pellentesque
sit amet porttitor eget dolor. Nisl nunc mi ipsum faucibus vitae. Purus sit amet luctus venenatis lectus magna fringilla urna. Sit amet tellus cras
adipiscing enim. Euismod nisi porta lorem mollis aliquam ut porttitor leo.',

'Morbi blandit cursus risus at ultrices. Adipiscing vitae proin sagittis nisl rhoncus mattis rhoncus. Sit amet commodo nulla facilisi. In fermentum
et sollicitudin ac **orci** phasellus egestas tellus. Sit amet risus nullam eget felis. Dapibus ultrices in iaculis nunc sed augue lacus viverra.
Dictum non consectetur a erat nam at. Odio ut enim blandit volutpat maecenas. Turpis cursus in hac habitasse platea. Etiam erat velit scelerisque in.
Auctor neque vitae tempus quam pellentesque nec nam aliquam. Odio pellentesque diam volutpat commodo sed egestas egestas. Egestas dui id ornare arcu odio ut.',

'Vivamus *vitae* quam eu nulla pretium lobortis. Sed ~~posuere~~ purus et magna ultricies molestie. Maecenas aliquet leo sit amet ante consectetur condimentum.
Nunc rhoncus dictum risus, vitae semper purus pellentesque a. Quisque in urna ornare, ultrices ex ac, vehicula urna. Sed sollicitudin finibus posuere.
Nulla volutpat nunc nec lectus placerat, at fringilla enim venenatis. Nunc id lacinia nisi. Sed sit amet odio a ex pellentesque ultrices. Maecenas rutrum
sit amet risus non fermentum. Praesent tristique neque in sagittis imperdiet.',

'[Interdum](/) et malesuada fames ac ante ipsum primis in faucibus. Phasellus laoreet leo ut nisl tempor, non mattis felis cursus. Aliquam ac ipsum non quam
hendrerit fringilla non gravida ipsum. In sed posuere tortor, nec varius enim. Aliquam scelerisque at augue sodales aliquam. Fusce eleifend placerat eros
sed tincidunt. Aliquam pellentesque quam ac sapien rhoncus consequat. Nullam cursus viverra blandit.',

'Duis gravida ~~libero~~ et dolor viverra imperdiet eu non sem. Curabitur in eleifend est. Maecenas et porttitor erat. Donec in faucibus felis, ullamcorper
tristique nibh. Vivamus ac efficitur est, sed **lobortis** ligula. Vivamus interdum ut nunc ac euismod. Praesent felis purus, varius ac vestibulum id, maximus
ac ligula. Etiam ex diam, finibus eu elit sit amet, viverra pharetra nulla. Donec tincidunt tortor egestas facilisis commodo. Ut ullamcorper arcu ut diam
efficitur, non ornare turpis finibus. Donec non luctus enim. Ut ac tincidunt ipsum. Donec nec urna in sem mattis convallis in auctor felis.
Mauris volutpat lobortis sem, varius placerat est pharetra ut.'
    ];

    private $word_with_bold;

    public function __construct($word_with_bold)

    {

        $this->word_with_bold  = $word_with_bold;

    }
    
    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string
    {
        // TODO: Implement get() method.
        $text = '';

        for ($i=0;$i<$paragraphs;$i++) {
            $text .= $this->paragraph[rand(0,5)] . "\n" . "\n";
        }

        if ($word != null) {
            $spaceArray = [];
            for ($i=0;$i<mb_strlen($text);$i++){
                if ($text[$i] === ' ') {
                    $spaceArray[] = $i;
                }
            }

            $posArray = [];

            for ($i=0; $i< $wordsCount; $i++) {
                $posArray[] = $spaceArray[rand(0, count($spaceArray)-1)];
            }

            rsort($posArray);
            $word = $this->word_with_bold . $word . $this->word_with_bold;
            for ($i=0; $i< $wordsCount; $i++) {
                $text = substr_replace($text, ' ' . $word, $posArray[$i], 0);
            }
        }

        return $text;
    }
}
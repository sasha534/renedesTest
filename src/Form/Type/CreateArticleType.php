<?php
/**
 * Created by PhpStorm.
 * User: sasha534
 * Date: 14.10.2019
 * Time: 6:14
 */

namespace App\Form\Type;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateArticleType extends  AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
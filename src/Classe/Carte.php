<?php


namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Carte
{
    private $session;
    private $entityManager;
    static $stockfini= null;

    /**
     * Carte constructor.
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session=$session;
        $this->entityManager=$entityManager;
    }


    public function add($id){


        $cart=$this->session->get('cart',[]);
        $quatity= $this->entityManager->getRepository(Product::class)->findOneById($id)->getStock();


        if (!empty($cart[$id])){

            if ($cart[$id] >= $quatity ){
                self::$stockfini="Produit insuffisant";
            }else{
                $cart[$id]++;
            }
        } else{
            $cart[$id] = 1;
        }

        $this->session->set('cart',$cart);
    }

    public function get(){
       return $this->session->get('cart');
    }

    public function remove(){
        return $this->session->remove('cart');
    }

    public function delete($id){

        $cart=$this->session->get('cart',[]);

        unset($cart[$id]);

        return $this->session->set('cart',$cart);

    }

    public function decrease($id){

        $cart=$this->session->get('cart',[]);
        if ($cart[$id] > 1){
            $cart[$id]--;
        }else{
            unset($cart[$id]);
        }

        return $this->session->set('cart',$cart);

    }

    public function getFull(){
        $cartComplet=[];

        if ($this->get()) {
            foreach ($this->get() as $id => $quatity) {
                $product_objet = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if (!$product_objet){
                    $this->delete($id);
                    continue;
                }
                $cartComplet[] = [
                    'product' => $product_objet,
                    'quantity' => $quatity
                ];
            }
        }

        return $cartComplet;
    }
}
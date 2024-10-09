<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Producto>
 *
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    public function crearProducto(int $claveProducto, string $nombre, float $precio)
    {
        $producto = new Producto();
        $em = $this->getEntityManager();

        // Inserta los valores. 
        // La clave ya esta verificada como unica 
        // desde ProductoController -> function_createProducto()
        $producto->setClaveProducto($claveProducto);
        $producto->setNombre($nombre);
        $producto->setPrecio($precio);


        $em->persist($producto);
        $em->flush();
    }

    public function borrarProducto(int $claveProducto)
    {
        $em = $this->getEntityManager();

        // Busca el producto
        $producto = $this->findOneBy(['claveProducto' => $claveProducto]);

        // Lo borra
        $em->remove($producto);
        $em->flush();
        
    }

    public function actualizarProducto(int $claveProducto, string $nombre, float $precio)
    {
        $em = $this->getEntityManager();
        //Busca el Producto
        $producto = $this->findOneBy(['claveProducto' => $claveProducto]); 

        // Si existe el producto...
        if ($producto) {
            // Actualizar los valores del producto
            $producto->setNombre($nombre);
            $producto->setPrecio($precio);
            
            $em->persist($producto);
            $em->flush();
        } else {
            throw new \Exception("Producto no encontrado");
        }

        $em->flush();
    }

    public function findAllProductos()
    {
        return $this->findAll(); 
    }

    public function findAllProductosASC()
    {
        return $this->findBy([],['claveProducto' => 'ASC']); 
    }

    public function findProductoByClaveProducto($claveProducto)
    {
        return $this->findOneBy(['claveProducto' => $claveProducto]);
    }

    public function findProductoByNombre($nombre)
    {
        // Busca todos los datos con Nombre parecido
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from(Producto::class, 'p')
            ->where('p.Nombre LIKE :Nombre')
            ->setParameter('Nombre', '%' . $nombre . '%')
            ->orderBy('p.claveProducto', 'ASC')
            ->getQuery()
            ->getResult();

    }
//    /**
//     * @return Producto[] Returns an array of Producto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Producto
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductoController extends AbstractController
{
    private ProductoRepository $productoRepository;

    public function __construct(ProductoRepository $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    #[Route('/producto', name: 'app_producto')]
    public function index(): Response
    {
        // Obtiene Todos los productos de foma ascendente
        $productos = $this->productoRepository->findAllProductosASC();
        return $this->render('producto/index.html.twig', [
            'productos' => $productos, 
            'controller_name' => 'ProductoController',
        ]);
    }
    
    #[Route('/producto/buscar', name: 'func_producto_buscar')]
    public function page_buscarProducto(Request $request): Response
    {
        $nombre = $request->request->get('nombre');
        // Obtiene Todos los productos con cierto nombre
        $productos = $this->productoRepository->findProductoByNombre($nombre);

        return $this->render('producto/busqueda.html.twig', [
            'productos' => $productos, 
            'controller_name' => 'ProductoController',
        ]);
    }

    #[Route('/producto/editar/{claveProducto}', name: 'page_producto_editar')]
    public function page_editar($claveProducto)
    {
        // Obtiene Todos los productos por clave
        $producto = $this->productoRepository->findProductoByClaveProducto($claveProducto);

        return $this->render('producto/editar.html.twig', [
            'producto' => $producto, 
            'claveProducto' => $claveProducto,
            'controller_name' => 'ProductoController',
        ]);
    }

    #[Route('/producto/editar', name: 'func_producto_editar')]
    public function function_editarProducto(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Variables
        $claveProducto = $request->request->get('claveProducto');
        $nombre = (string) $request->request->get('nombre');
        $precio = $request->request->get('precio');

        // Validacion de Datos para la BDD
        if($this->isProductNotValid($claveProducto, $nombre, $precio))
            return $this->redirectToRoute('app_producto');

        // Ejecucion en la BDD
        $this->productoRepository->actualizarProducto($claveProducto, $nombre, $precio);
        return $this->redirectToRoute('app_producto');
    }

    #[Route('/producto/borrar/{claveProducto}', name: 'func_producto_borrar')]
    public function function_borrarProducto($claveProducto, EntityManagerInterface $entityManager): Response
    {
        // Busca el producto por clave
        $Producto = $entityManager->getRepository(Producto::class)->findOneBy(['claveProducto' => $claveProducto]);

        // Si existe...
        if($Producto)
        {
            // Borrar el producto
            $this->productoRepository->borrarProducto($claveProducto);
            return $this->redirectToRoute('app_producto');
        }


        return $this->redirectToRoute('app_producto');
    }

    #[Route('/producto/create', name: 'func_producto_create')]
    public function function_createProducto(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Manejo de Variables
        $claveProducto = $request->request->get('claveProducto');
        $nombre = (string) $request->request->get('nombre');
        $precio = $request->request->get('precio');

        // Validacion de datos
        if($this->isProductNotValid($claveProducto, $nombre, $precio))
            return $this->redirectToRoute('app_producto');

        // Validar la clave como unica
        $claveRepetclaveProductoo = $entityManager->getRepository(Producto::class)->findOneBy(['claveProducto' => $claveProducto]);
        if($claveRepetclaveProductoo)
        {
            $this->addFlash('error', 'La clave del producto ya está en uso.');
            return $this->redirectToRoute('app_producto');
        }

        // Inserción en la BDD
        $this->productoRepository->crearProducto($claveProducto, $nombre, $precio);

        // Redirigir a producto
        return $this->redirectToRoute('app_producto');
    }

    public function isProductNotValid($claveProducto, $nombre, $precio)
    {
        // Validacion que los datos NO sean nulos ni diferente tipo
        if($claveProducto == NULL || $nombre == NULL || $precio == NULL)
            return true;
        if(!is_numeric($claveProducto)) 
            return true;
        if(!is_numeric($precio)) 
            return true;

        return false;
    }
    
    #[Route('producto/exportar', name: 'func_producto_exportar')]
    public function function_productosExportar(): Response
    {
        // Obtiene todos los productos
        $productos = $this->productoRepository->findAllProductosASC();

        // Genera una hoja de calculo (Excell)
        $spreadsheet = new Spreadsheet();
        $excell = $spreadsheet->getActiveSheet();

        // Define las filas o cabeceras del Excell
        $excell->setCellValue('A1', 'Clave Producto');
        $excell->setCellValue('B1', 'Nombre');
        $excell->setCellValue('C1', 'Precio');

        
        $row = 2; // Empieza desde la segunda fila
        // Inserta todos los productos
        foreach ($productos as $producto) {
            $excell->setCellValue('A' . $row, $producto->getClaveProducto());
            $excell->setCellValue('B' . $row, $producto->getNombre());
            $excell->setCellValue('C' . $row, $producto->getPrecio());
            $row++;
        }
        
        // Generación del Excell
        $writer = new Xlsx($spreadsheet);
        $response = new Response();
        $fileName = 'productos.xlsx';
        ob_start();
        $writer->save('php://output');
        $response->setContent(ob_get_clean());
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}

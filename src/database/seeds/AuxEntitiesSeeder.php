<?php namespace PCI\Database;

/**
 * @todo: a espera de @Phantom66 para la especificacion real de algunas entidades.
 */
class AuxEntitiesSeeder extends BaseSeeder
{

    public function run()
    {
        $this->command->line('Empezando Seeding de Modelos relacionados con usuario!');

        $data = [
            'PCI\Models\Gender' => [
                ['desc' => 'Masculino'],
                ['desc' => 'Femenino']
            ],

            'PCI\Models\ItemType' => [
                ['desc' => 'Perecedero'],
                ['desc' => 'No Perecedero']
            ],

            'PCI\Models\Maker' => [
                ['desc' => 'Empresa X'],
                ['desc' => 'Empresa Y'],
                ['desc' => 'Empresa Z'],
            ],

            'PCI\Models\MovementType' => [
                ['desc' => 'Entrada'],
                ['desc' => 'Salida'],
                ['desc' => 'Otro'],
            ],

            'PCI\Models\Nationality' => [
                ['desc' => 'Venezolano'],
                ['desc' => 'Extrangero'],
            ],

            'PCI\Models\NoteType' => [
                ['desc' => 'Entrada (entrada)'],
                ['desc' => 'Entrega (salida)'],
            ],

            'PCI\Models\PetitionType' => [
                ['desc' => 'Entrada (entrada)'],
                ['desc' => 'Entrega (salida)'],
            ],

            'PCI\Models\Position' => [
                ['desc' => 'Entrada (entrada)'],
                ['desc' => 'Entrega (salida)'],
            ],

            /**
             * Administrador no hay que crearlo nuevamente.
             */
            'PCI\Models\Profile' => [
                ['desc' => 'Usuario'],
                ['desc' => 'Desactivado'],
            ],

            'PCI\Models\Category' => [
                ['desc' => 'Alimentos'],
                ['desc' => 'Herramientas'],
                ['desc' => 'Articulos de Limpieza'],
                ['desc' => 'Articulos Medicos'],
            ],

            'PCI\Models\SubCategory' => [
                /**
                 * Alimentos
                 */
                ['desc' => 'Empacados', 'category_id' => 1],
                ['desc' => 'Harinas', 'category_id' => 1],
                ['desc' => 'Verduras y Hortalizas', 'category_id' => 1],

                /**
                 * Herramientas
                 */
                ['desc' => 'Electricas', 'category_id' => 2],
                ['desc' => 'Mecanicas', 'category_id' => 2],
                ['desc' => 'Hidraulicas', 'category_id' => 2],
                ['desc' => 'Miscelaneos', 'category_id' => 2],
                ['desc' => 'Otro', 'category_id' => 2],

                /**
                 * Articulos de Limpieza
                 */
                ['desc' => 'Coletos', 'category_id' => 3],
                ['desc' => 'Detergentes', 'category_id' => 3],
                ['desc' => 'Cepillos', 'category_id' => 3],
                ['desc' => 'Otro', 'category_id' => 3],

                /**
                 * Articulos Medicos
                 */
                ['desc' => 'Inyectadoras', 'category_id' => 4],
                ['desc' => 'Micelaneos', 'category_id' => 4],
                ['desc' => 'Otro', 'category_id' => 4],
            ],
        ];

        $this->seedModels($data);
    }

    /**
     * Arreglo de Entidades secundarias o auxiliares en el sistema.
     * @return array
     */
    public static function getModels()
    {
        return [
            'PCI\Models\Category',
            'PCI\Models\Gender',
            'PCI\Models\ItemType',
            'PCI\Models\Maker',
            'PCI\Models\MovementType',
            'PCI\Models\Nationality',
            'PCI\Models\NoteType',
            'PCI\Models\Parish',
            'PCI\Models\PetitionType',
            'PCI\Models\Position',
            'PCI\Models\Profile',
            'PCI\Models\State',
            'PCI\Models\SubCategory',
            'PCI\Models\Town',
        ];
    }
}

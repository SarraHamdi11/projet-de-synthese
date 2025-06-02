<?php

namespace App\Exports;

use App\Models\Annonce;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AnnoncesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $listings;

    public function __construct($listings)
    {
        $this->listings = $listings;
    }

    public function collection()
    {
        return $this->listings;
    }

    public function headings(): array
    {
        // Headers for the main data table (starting on row 3)
        return [
            'ID',
            'Propriétaire',
            'Titre',
            'Statut',
            'Date de Publication',
            'Prix',
            'Ville',
            'Type',
            'Nombre Locataire',
            'Note',
        ];
    }

    public function map($listing): array
    {
        // Map the listing data for the main table
        return [
            $listing->id ?? '',
            $listing->proprietaire ? ($listing->proprietaire->prenom . ' ' . $listing->proprietaire->nom_uti) : 'N/A',
            $listing->titre_anno ?? '',
            $listing->statut_anno ?? 'Indisponible',
            $listing->date_publication_anno ? $listing->date_publication_anno->format('d/m/Y') : 'N/A',
            $listing->logement->prix_log ?? 0,
            $listing->logement->ville ?? 'N/A',
            $listing->logement->type_log ?? 'N/A',
            $listing->logement->nombre_colocataire_log ?? 0,
            number_format($listing->average_note ?? 0, 1) . '/5',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Ligne 1 : Titre
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'FindStay - Liste des annonces');
        $sheet->getRowDimension(1)->setRowHeight(35);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '1E40AF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
        ]);

        // 2. Ligne 2 : Attributs internes
        $attributes = [
            'id', 'propriétaire', 'titre', 'statut', 'date de publication',
            'prix', 'ville', 'type', 'nombre locataire', 'note'
        ];
        $columnIndex = 'A';
        foreach ($attributes as $attribute) {
            $sheet->setCellValue($columnIndex . '2', $attribute);
            $columnIndex++;
        }

        $sheet->getStyle('A2:J2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => '000000']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'E0E0E0']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        // 3. Données : uniquement alignement et texte (sans couleur de fond)
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 2) {
            $sheet->getStyle("A3:J{$lastRow}")->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'font' => [
                    'size' => 11
                ],
            ]);
        }

        // 4. Bordures pour tout le tableau
        $sheet->getStyle("A1:J{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '3B82F6'],
                ],
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '1E40AF']
                ]
            ],
        ]);

        // 5. Auto-size colonnes
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 6. Wrap text et indentation
        $sheet->getStyle("A1:J{$lastRow}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("A1:J{$lastRow}")->getAlignment()->setIndent(1);
    }
}
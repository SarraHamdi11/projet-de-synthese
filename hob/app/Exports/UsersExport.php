<?php

namespace App\Exports;

use App\Models\Utilisateur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        // Headers for the main data table (starting on row 3)
        return [
            'ID',
            'Prénom',
            'Nom',
            'Rôle',
            'Email',
            'Numéro téléphone',
            'Ville',
            'Date inscription',
            'Nombre annonces',
            'Note moyenne',
        ];
    }

    public function map($user): array
    {
        // Map the user data for the main table
        return [
            $user->id ?? '',
            $user->prenom ?? '',
            $user->nom_uti ?? '',
            $user->role_uti ?? '',
            $user->email_uti ?? '',
            $user->tel_uti ?? '',
            $user->ville ?? '',
            $user->date_inscription_uti ? $user->date_inscription_uti->format('d/m/Y') : '',
            $user->annonces_count ?? 0,
            $user->role_uti === 'proprietaire' ? number_format($user->average_note ?? 0, 2) . ' / 100' : 'N/A',
        ];
    }

   public function styles(Worksheet $sheet)
{
    // 1. Ligne 1 : Titre
    $sheet->mergeCells('A1:J1');
    $sheet->setCellValue('A1', 'FindStay - Liste des utilisateurs');
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
        'id', 'nom', 'prenom', 'role', 'email',
        'numero téléphone', 'ville', 'date inscription',
        'nombre d’annonces', 'note moyenne'
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

    // 5. Bordures pour tout le tableau
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

    // 6. Auto-size colonnes
    foreach (range('A', 'J') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // 7. Wrap text et indentation
    $sheet->getStyle("A1:J{$lastRow}")->getAlignment()->setWrapText(true);
    $sheet->getStyle("A1:J{$lastRow}")->getAlignment()->setIndent(1);
}

}
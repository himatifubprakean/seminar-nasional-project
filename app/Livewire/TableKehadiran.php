<?php

namespace App\Livewire;

use App\Models\DaftarHadir;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;

final class TableKehadiran extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'table-kehadiran-iar161-table';

    public function setUp(): array
    {
        $this->showCheckBox();


        return [
            PowerGrid::exportable(fileName: 'export_kehadiran_semnas')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return DaftarHadir::query()->with('peserta')->with('sertifikat');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('id_peserta')
            ->add('waktu_hadir')
            ->add('status')
            ->add('created_at')
            ->add('no_peserta', fn($daftarHadir) => e($daftarHadir->peserta?->nomor_peserta ?? '-'))
            ->add('email_peserta', fn($daftarHadir) => e($daftarHadir->peserta?->email ?? '-'))
            ->add('nama_peserta', fn($daftarHadir) => e($daftarHadir->peserta?->name ?? '-'))
            ->add('kodeUnik_peserta', fn($daftarHadir) => e($daftarHadir->sertifikat?->code_unik ?? '-'))
            ->add('statusSertif_peserta', fn($daftarHadir) => e($daftarHadir->sertifikat?->status ?? '-'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID Peserta', 'id_peserta')
                ->sortable()
                ->searchable(),
            Column::make('Nomor Peserta', 'no_peserta')
                ->sortable(),
            Column::make('Nama', 'nama_peserta')
                ->sortable(),
            Column::make('Email', 'email_peserta')
                ->sortable(),
            Column::make('Waktu hadir', 'waktu_hadir')
                ->sortable(),
            Column::make('Status Kehadiran', 'status')
                ->sortable(),

            Column::make('Kode Unik', 'kodeUnik_peserta')
                ->sortable(),
            Column::make('Status Sertifikat', 'statusSertif_peserta')
                ->sortable(),

            // Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    // public function actions(DaftarHadir $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}

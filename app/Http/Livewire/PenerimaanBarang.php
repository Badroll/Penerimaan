<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Supplier;
use App\Models\Karat;
use App\Models\Penerimaan;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use DB;

class PenerimaanBarang extends Component
{
    use WithFileUploads;

    public $photo;
    public $no_penerimaan_barang;
    public $no_surat_jalan;
    public $supplier_id;
    public $tanggal;
    public $items = [];
    public $total_berat_real;
    public $total_berat_kotor = 0;
    public $berat_timbangan;
    public $berat_selisih;
    public $catatan;
    public $tipe_pembayaran;
    public $harga_beli;
    public $tanggal_jatuh_tempo;
    public $nama_pengirim;
    public $pic;

    protected $rules = [
        'photo' => 'required|image|max:2048',
        'no_surat_jalan' => 'required',
        'supplier_id' => 'required',
        'tanggal' => 'required|date|before_or_equal:today',
        'items.*.karat' => 'required',
        'items.*.berat_real' => 'required|numeric|gt:0',
        'items.*.berat_kotor' => 'required|numeric|gt:0',
        'total_berat_real' => 'required|numeric|gt:0',
        'total_berat_kotor' => 'required|numeric|gt:0',
        'berat_timbangan' => 'required|numeric|gt:0',
        'berat_selisih' => 'required|numeric',
        'tipe_pembayaran' => 'required',
        'nama_pengirim' => 'required',
    ];

    public function rules()
    {
        if ($this->tipe_pembayaran == 'Jatuh Tempo') {
            $this->rules['tanggal_jatuh_tempo'] = 'required|date|after_or_equal:today';
        } else {
            $this->rules['harga_beli'] = 'required|numeric|gt:0';
        }

        return $this->rules;
    }


    public function mount()
    {
        $this->no_penerimaan_barang = 'INV' . now()->timestamp;
        $this->tanggal = now()->toDateString();
        $this->pic = Auth::user()->name;
    }

    public function addItem()
    {
        $this->items[] = ['karat' => '', 'berat_real' => '', 'berat_kotor' => ''];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->calculateTotalBeratKotor();
    }

    public function calculateTotalBeratKotor()
    {
        $this->total_berat_kotor = array_sum(array_column($this->items, 'berat_kotor'));
        $this->calculateBeratSelisih();
    }

    public function calculateBeratSelisih()
    {
        $this->berat_selisih = $this->berat_timbangan - $this->total_berat_real;
    }

    public function updatedBeratTimbangan()
    {
        $this->calculateBeratSelisih();
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $photoPath = $this->photo->store('photos', 'public');
            $fields = [
                'no_penerimaan' => $this->no_penerimaan_barang,
                'no_invoice' => $this->no_surat_jalan,
                'foto_path' => $photoPath,
                'supplier' => $this->supplier_id,
                'tanggal' => $this->tanggal,
                'berat_real' => $this->total_berat_real,
                'berat_kotor' => $this->total_berat_kotor,
                'berat_timbangan' => $this->berat_timbangan,
                'berat_selisih' => $this->berat_selisih,
                'catatan' => $this->catatan,
                'pengirim' => $this->nama_pengirim,
                'pic' => $this->pic,
                'tipe_pembayaran' => $this->tipe_pembayaran,
            ];
            if ($this->tipe_pembayaran == "Jatuh Tempo") {
                $fields['tanggal_tempo'] = $this->tanggal_jatuh_tempo;
            } else {
                $fields['harga_beli'] = $this->harga_beli;
            }
            //dd($fields);
            $penerimaan = Penerimaan::create($fields);
    
            $items = [];
            foreach($this->items as $k => $item){
                $items[] = [
                    'karat' => $item["karat"],
                    'berat_real' => $item["berat_real"],
                    'berat_kotor' => $item["berat_kotor"],
                ];
            }
        
            foreach ($items as $item) {
                $penerimaan->items()->create($item);
            }
        });


    }

    public function render()
    {
        return view('livewire.penerimaan-barang', [
            'suppliers' => Supplier::all(),
            'karats' => Karat::all()
        ]);
    }
}

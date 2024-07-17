<div class="container">
    <form wire:submit.prevent="save">
        <div class="row">
            <!-- Left Column: Photo Upload and Preview -->
            <div class="col-4">
                <div class="form-group">
                    <label for="photo">Upload Gambar</label>
                    <input type="file" id="photo" class="form-control" wire:model="photo">
                    @error('photo') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    <!-- Image Preview -->
                    <div class="mt-3">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="img-thumbnail">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Other Form Inputs -->
            <div class="col-8">

                <div class="row">
                    <!-- No Penerimaan Barang -->
                    <div class="form-group col-6">
                        <label for="no_penerimaan_barang">No Penerimaan Barang</label>
                        <input type="text" id="no_penerimaan_barang" class="form-control" wire:model="no_penerimaan_barang" readonly>
                        @error('no_penerimaan_barang') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    <!-- No Surat Jalan / Invoice -->
                    <div class="form-group col-6">
                        <label for="no_surat_jalan">No Surat Jalan / Invoice</label>
                        <input type="text" id="no_surat_jalan" class="form-control" wire:model="no_surat_jalan">
                        @error('no_surat_jalan') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <!-- Supplier -->
                    <div class="form-group col-6">
                        <label for="supplier_id">Supplier</label>
                        <select id="supplier_id" class="form-control" wire:model="supplier_id">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal -->
                    <div class="form-group col-6">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" id="tanggal" class="form-control" wire:model="tanggal" max="{{ now()->toDateString() }}">
                        @error('tanggal') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Multiple Input -->
                <div class="form-group mt-2">
                    <label>Item</label>
                    @foreach($items as $index => $item)
                        <div class="item-group row mb-2">
                            <div class="col-md-4">
                                <select wire:model="items.{{ $index }}.karat" class="form-control">
                                    <option value="">Pilih Karat</option>
                                    @foreach($karats as $karat)
                                        <option value="{{ $karat->id }}">{{ $karat->value }}</option>
                                    @endforeach
                                </select>
                                @error('items.' . $index . '.karat') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3">
                                <input type="text" wire:model="items.{{ $index }}.berat_real" class="form-control" placeholder="Berat Real">
                                @error('items.' . $index . '.berat_real') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3">
                                <input type="text" wire:model="items.{{ $index }}.berat_kotor" class="form-control" placeholder="Berat Kotor" wire:change="calculateTotalBeratKotor">
                                @error('items.' . $index . '.berat_kotor') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger" wire:click="removeItem({{ $index }})">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                    @if(count($items) == 0)
                        <br>
                    @endif
                    <button type="button" class="btn btn-primary" wire:click="addItem">Tambah</button>
                </div>

                <div class="row mt-2">
                    <!-- Total Berat Real -->
                    <div class="form-group col-3">
                        <label for="total_berat_real">Total Berat Real</label>
                        <input type="text" id="total_berat_real" class="form-control" wire:model="total_berat_real">
                        @error('total_berat_real') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Total Berat Kotor -->
                    <div class="form-group col-3">
                        <label for="total_berat_kotor">Total Berat Kotor</label>
                        <input type="text" id="total_berat_kotor" class="form-control" wire:model="total_berat_kotor" readonly>
                        @error('total_berat_kotor') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Berat Timbangan -->
                    <div class="form-group col-3">
                        <label for="berat_timbangan">Berat Timbangan</label>
                        <input type="text" id="berat_timbangan" class="form-control" wire:model="berat_timbangan">
                        @error('berat_timbangan') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Berat Selisih -->
                    <div class="form-group col-3">
                        <label for="berat_selisih">Berat Selisih</label>
                        <input type="text" id="berat_selisih" class="form-control" wire:model="berat_selisih" readonly>
                        @error('berat_selisih') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Catatan -->
                <div class="form-group mt-2">
                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" class="form-control" wire:model="catatan"></textarea>
                </div>

                <div class="row mt-2">
                    <!-- Tipe Pembayaran -->
                    <div class="form-group col-6">
                        <label for="tipe_pembayaran">Tipe Pembayaran</label>
                        <select id="tipe_pembayaran" class="form-control" wire:model="tipe_pembayaran">
                            <option value="">Pilih Tipe Pembayaran</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Jatuh Tempo">Jatuh Tempo</option>
                        </select>
                        @error('tipe_pembayaran') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    @if ($tipe_pembayaran == 'Lunas')
                        <!-- Harga Beli -->
                        <div class="form-group col-6">
                            <label for="harga_beli">Harga Beli</label>
                            <input type="text" id="harga_beli" class="form-control" wire:model="harga_beli">
                            @error('harga_beli') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    @if ($tipe_pembayaran == 'Jatuh Tempo')
                        <!-- Tanggal Jatuh Tempo -->
                        <div class="form-group col-6">
                            <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
                            <input type="date" id="tanggal_jatuh_tempo" class="form-control" wire:model="tanggal_jatuh_tempo" min="{{ now()->toDateString() }}">
                            @error('tanggal_jatuh_tempo') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <div class="row mt-2">
                    <!-- Nama Pengirim -->
                    <div class="form-group col-6">
                        <label for="nama_pengirim">Nama Pengirim</label>
                        <input type="text" id="nama_pengirim" class="form-control" wire:model="nama_pengirim">
                        @error('nama_pengirim') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>

                    <!-- PIC -->
                    <div class="form-group col-6">
                        <label for="pic">PIC</label>
                        <input type="text" id="pic" class="form-control" wire:model="pic" readonly>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="form-group col-11">
                    </div>
                    <div class="form-group col-1">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('saved', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disimpan',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });
            });
        });
    </script>

<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Master Database Jamaah</h3>
              <nav aria-label="breadcrumb">
                <?= button($btn_add, TRUE, 'button', 'class="btn tambah-jamaah btn-primary" data-toggle="modal" data-target="#mustahikModal"');?>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-3">Daftar Jamaah</h4>
                  </div>
                  <div class="card-body">
                    <h3 class="subtitle"><?= $this->app->nama_masjid ?></h3>
                    <div class="table-responsive mt-5">
                      <table class="table table-striped table-bordered w-100" id="tblMustahik">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nama Kepala Keluarga</th>
                                <th>Tempat Lahir</th>
                                <th>Tgl Lahir</th>
                                <th>Gender</th>
                                <th>Gol. Darah</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Status</th>
                                <th>Kategori</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mustahik as $m) :?>
                            <tr>
                                <td><?= $m->nama ?></td>
                                <td><?= $m->nama_kk ?></td>
                                <td><?= $m->tempat_lahir ?></td>
                                <td><?= $m->tgl_lahir ?></td>
                                <td><?= $m->gender ?></td>
                                <td><?= $m->gol_darah ?></td>
                                <td><?= $m->pekerjaan ?></td>
                                <td><?= $m->alamat ?></td>
                                <td><?= $m->telepon ?></td>
                                <td><?= $m->status_p ?></td>
                                <td><?= $m->kategori ?></td>
                                <td><?= $m->real_name ?></td>
                                <td>
                                  <?= button($btn_edit, FALSE, 'button', 'data-id="'.encrypt($m->id_jamaah).'" class="btn btn-sm btn-warning edit-mustahik" data-toggle="modal" data-target="#mustahikModal"');?>

                                  <?= button($btn_del, FALSE, 'button', 'data-id="'.encrypt($m->id_jamaah).'" class="btn btn-sm btn-danger delete-btn"');?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <th>Nama</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Tempat Lahir</th>
                            <th>Tgl Lahir</th>
                            <th>Gender</th>
                            <th>Gol. Darah</th>
                            <th>Pekerjaan</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Kategori</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="mustahikModal" tabindex="-1" role="dialog" aria-labelledby="Jamaah" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'method="post" id="mustahikForm" accept-charset="utf-8"');?>
              <div class="row">
                  <div class="col-md-6">
                      <input type="hidden" name="id_jamaah" id="id_jamaah" value="">
                      <div class="form-group">
                          <label for="nama">Nama *</label>
                          <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="nama_kk">Nama Kepala Keluarga</label>
                          <input type="text" id="nama_kk" name="nama_kk" class="form-control" placeholder="Nama KK" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="tempat_lahir">Tempat Lahir *</label>
                          <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required="required">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="tgl_lahir">Tanggal Lahir *</label>
                          <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control" placeholder="28-12-1986">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="gender">Gender *</label>
                          <select name="gender" id="gender" class="form-control text-white" required="required">
                            <option value="">Jenis Kelamin</option>
                            <option value="pria">Pria</option>
                            <option value="wanita">Wanita</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="gol_darah">Golongan Darah</label>
                          <input type="text" id="gol_darah" name="gol_darah" class="form-control" placeholder="Golongan Darah">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="status_p">Status *</label>
                          <select name="status_p" id="status_p" class="form-control text-white" required="required">
                            <option value="">Status Perkawinan</option>
                            <option value="menikah">Sudah Menikah</option>
                            <option value="belum menikah">Belum Menikah</option>
                            <option value="janda">Janda</option>
                            <option value="duda">Duda</option>
                            <option value="balita">Balita</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="kategori">Kategori Mustahik *</label>
                          <select name="kategori" id="kategori" class="form-control text-white" required="required">
                            <option value="">Pilih Kategori</option>
                            <option value="tidak">Tidak</option>
                            <option value="fakir">Fakir</option>
                            <option value="miskin">Miskin</option>
                            <option value="riqab">Riqab</option>
                            <option value="gharim">Gharim</option>
                            <option value="ibnu sabil">Ibnu Sabil</option>
                            <option value="mualaf">Mualaf</option>
                            <option value="amil zakat">Amil Zakat</option>
                            <option value="yatim">Yatim</option>
                            <option value="piatu">Piatu</option>
                            <option value="janda">Janda</option>
                            <option value="fi sabilillah">Fi Sabilillah</option>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="pekerjaan">Pekerjaan</label>
                          <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" placeholder="Pekerjaan">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat"></textarea>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="telepon">No. Telepon</label>
                          <input type="text" id="telepon" name="telepon" class="form-control" placeholder="021xxxxxxx / +62xxxxxxx">
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="reset" data-dismiss="modal">Reset</button>
                <input type="submit" id="submit" class="my-3 btn btn-small btn-success" name="submit" value="Submit">
                </form>
            </div>
          </div>
        </div>
      </div>
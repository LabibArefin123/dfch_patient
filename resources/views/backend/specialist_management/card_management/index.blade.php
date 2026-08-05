@extends('adminlte::page')

@section('title', 'Specialist Cards')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-user-md text-danger"></i>
            Specialist Card List
        </h1>

    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-id-card"></i>
                Specialist Cards
            </h3>

            <div class="card-tools">
                <span class="badge badge-primary">
                    Total : {{ $cards->total() }}
                </span>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered text-nowrap">
                <thead class="bg-primary text-center">
                    <tr>
                        <th width="60">SL</th>
                        <th width="100">Background</th>
                        <th>Card Name</th>
                        <th>Specialist</th>
                        <th>Theme</th>
                        <th width="100">Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cards as $card)
                        <tr>
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center align-middle">
                                @if ($card->background_image_url)
                                    <img src="{{ $card->background_image_url }}" alt="{{ $card->name }}"
                                        class="img-thumbnail zoomable"
                                        style="width:80px;height:80px;object-fit:contain;cursor:pointer;"
                                        data-bs-toggle="modal" data-bs-target="#imageZoomModal"
                                        data-bs-img-src="{{ $card->background_image_url }}">
                                @else
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                @endif
                            </td>

                            <td class="align-middle">
                                <strong>{{ $card->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $card->slug }}</small>
                            </td>

                            <td class="align-middle">
                                @if ($card->specialist)
                                    <strong>{{ $card->specialist->name }}</strong>
                                    <br>
                                    <small>{{ $card->specialist->designation }}</small>
                                @else
                                    <span class="text-danger">
                                        No Specialist
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-secondary">{{ ucfirst($card->card_theme) }}</span>
                            </td>
                            <td class="text-center align-middle">
                                @if ($card->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <a href="{{ route('specialist-cards.show', $card->id) }}" class="btn btn-sm btn-warning"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('specialist-cards.edit', $card->id) }}" class="btn btn-sm btn-primary"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('specialist-cards.destroy', $card->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this card?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                <i class="fas fa-id-card fa-3x mb-3"></i>
                                <br>
                                No Specialist Cards Found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $cards->links() }}
        </div>
    </div>

    <div style="height: 50px;"></div>
@stop

@extends('layouts.viho')

@section('moreCSS')
    <!-- Add any custom CSS if needed -->
@endsection

@section('body')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Create New Lab Fee</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('labfees.store') }}" method="POST">
                    @csrf
                    <!-- English Name Field -->
                    <div class="mb-3">
                        <label for="english_name" class="form-label">English Name</label>
                        <input type="text" class="form-control @error('english_name') is-invalid @enderror" id="english_name" name="english_name" value="{{ old('english_name') }}">
                        @error('english_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Arabic Name Field -->
                    <div class="mb-3">
                        <label for="arabic_name" class="form-label">Arabic Name</label>
                        <input type="text" class="form-control @error('arabic_name') is-invalid @enderror" id="arabic_name" name="arabic_name" value="{{ old('arabic_name') }}" >
                        @error('arabic_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fee Field -->
                    <div class="mb-3">
                        <label for="fee" class="form-label">Fee</label>
                        <input type="number" class="form-control @error('fee') is-invalid @enderror" id="fee" name="fee" value="{{ old('fee') }}">
                        @error('fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Select -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" >
                            <option value="">Select Category</option>
                            <option value="Agriculture" {{ old('category') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                            <option value="Veterinary" {{ old('category') == 'Veterinary' ? 'selected' : '' }}>Veterinary</option>
                            <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                            <option value="QualityControl" {{ old('category') == 'QualityControl' ? 'selected' : '' }}>Quality Control</option>
                            <option value="Construction" {{ old('category') == 'Construction' ? 'selected' : '' }}>Construction</option>
                        </select>
                        @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('labfees.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('moreJs')
    <!-- Add any custom JS if needed -->
@endsection

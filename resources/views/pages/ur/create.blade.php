<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>CREATE</h1>
    <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf

        {{-- TITOLO --}}
        <div class="form-group">
            <label for="apartments-title" class="form-label text-white-50">Titolo</label>
            <input type="text" required max="255"  id="apartments-title" class="form-control"
            placeholder="Inserisci il titolo dell'appartamento" name="title" value="{{ old('title')}}">
            @error('title')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>
        
        <div class="mb-3 form-group">
            <label for="project-image" class="form-label">Scegli una immagine</label>
            <input type="file" class="form-control" name="image" id="project-image" placeholder="project-image" aria-describedby="fileHelpId">
            @error('image')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>

        {{-- DESCRIZIONE --}}
        <div class="form-group">
            <label for="apartments-description" class="form-label text-white-50">Descrizione</label>
            <textarea id="apartments-description" class="form-control"
            placeholder="Inserisci la descrizione dell'appartamento" name="description">{{ old('description')}}</textarea>
            @error('description')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>

        {{-- INDIRIZZO --}}
        <div class="form-group">
            <label for="apartments-address" class="form-label text-white-50">Indirizzo</label>
            <input type="text" required max="255"  id="apartments-address" class="form-control"
            placeholder="Inserisci l'indirizzo dell'appartamento" name="address" value="{{ old('address')}}">
            @error('address')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <select name="apartments-city" id="apartments-city">
                <option selected>Scegli una città</option>
                @foreach ($cities as $city)
                    <option>{{$city}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="project-short_description" class="form-label text-white-50">Descrizione breve</label>
            <input type="text" required max="255"  id="project-short_description" class="form-control"
            placeholder="Inserisci BREVE descrizione del progetto" name="short_description" value="{{ old('short_description')}}">
            @error('short_description')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>


        <div class="form-group">
            <label for="project-relase_date" class="form-label text-white-50">data publicazione</label>
            <input type="date" required id="project-relase_date" class="form-control" name="relase_date"
                min="1900-01-01" value="{{ old('relase_date')}}">
            @error('relase_date')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>


        <div class="form-group mt-3">
            <label for="project-type_id" class="form-label text-white-50">type</label>
            <select required name="type_id" id="type_id">
                <option value="">scegli un tipo</option>
                @foreach ($types as $type)
                <option value="{{$type->id}}" {{ old('type_id') == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                @endforeach
            </select>
            @error('type_id')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="project-visibility" class="form-label text-white-50">visibilità</label>
            <div>
                <input type="radio" name="visibility" value="0" ><span class="text-white-50">privato</span>
                <input type="radio" name="visibility" value="1" checked="checked"> <span class="text-white-50">publico</span>
            </div>
        </div>
        @error('visbility')
            <span style="color: red; text-transform: uppercase">{{$message}}</span>
        @enderror

        <div class="form-group mt-3">
            @foreach ($tags as $tag)
            <div class="form-check">
                <label for="project-checkbox-{{$tag->id}}" class="form-label text-white-50">{{$tag->name}}</label>
                <input class="form-check-input" type="checkbox" name="tags[]" value="{{$tag->id}}" id="project-checkbox-{{$tag->id}}"
                @if(old('tags') && in_array($tag->id, old('tags'))) checked @endif>
            </div>           
            @endforeach
            @error('tag')
            <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="project-project_link" class="form-label text-white-50">Link progetto</label>
            <input type="text" required max="255"  id="project-project_link" class="form-control"
            placeholder="Inserisci link del progetto" name="project_link" value="{{ old('project_link')}}">
            @error('project_link')
                <span style="color: red; text-transform: uppercase">{{$message}}</span>
            @enderror
        </div>
        <button type="submit" class="my-3 btn btn-primary">Aggiungi progetto </button>
    </form>
</body>
</html>
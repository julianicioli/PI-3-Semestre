package com.aquasense.noticias.controller;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseStatus;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.server.ResponseStatusException;

import com.aquasense.noticias.model.Noticia;
import com.aquasense.noticias.repository.CategoriaRepository;
import com.aquasense.noticias.repository.NoticiaRepository;
import com.aquasense.noticias.repository.UsuarioRepository;

import jakarta.validation.Valid;

@RestController
@RequestMapping("/noticias")
@CrossOrigin(origins = "*", allowedHeaders = "*")
public class NoticiaController {

	@Autowired
	private NoticiaRepository noticiaRepository;

	@Autowired
	private CategoriaRepository categoriaRepository;

	@Autowired
	private UsuarioRepository usuarioRepository;

	// Listar todas
	@GetMapping
	public ResponseEntity<List<Noticia>> getAll() {
		return ResponseEntity.ok(noticiaRepository.findAll());
	}

	// Buscar pelo Id
	@GetMapping("/{id}")
	public ResponseEntity<Noticia> getById(@PathVariable Long id) {
		return noticiaRepository.findById(id).map(resposta -> ResponseEntity.ok(resposta))
				.orElse(ResponseEntity.notFound().build());
	}

	// Buscar pelo título
	@GetMapping("/titulo/{titulo}")
	public ResponseEntity<List<Noticia>> getAllByTitulo(@PathVariable String titulo) {
		return ResponseEntity.ok(noticiaRepository.findAllByTituloContainingIgnoreCase(titulo));
	}

	// Criar nova notícia
	@PostMapping
	public ResponseEntity<Noticia> post(@Valid @RequestBody Noticia noticia) {
		if (categoriaRepository.existsById(noticia.getCategoria().getId())) {
			noticia.setId(null);
			return ResponseEntity.status(HttpStatus.CREATED).body(noticiaRepository.save(noticia));
		}
		throw new ResponseStatusException(HttpStatus.BAD_REQUEST, "A categoria não existe!", null);
	}
	
	// Atualizar notícia:
	@PutMapping
	public ResponseEntity<Noticia> put(@Valid @RequestBody Noticia noticia) {
		if (noticiaRepository.existsById(noticia.getId())) {	// Verifica se a notícia existe
			if (categoriaRepository.existsById(noticia.getCategoria().getId())) { 	// Verifica se a categoria informada existe
				return ResponseEntity.ok(noticiaRepository.save(noticia)); 	// Atualiza a notícia e retorna 200 OK
			} else {
				throw new ResponseStatusException(HttpStatus.BAD_REQUEST, "A categoria não existe!");
			}
		}
		return ResponseEntity.notFound().build(); 	// Caso o ID da notícia não exista no banco
	}

	// Apagar notícia
	@ResponseStatus(HttpStatus.NO_CONTENT)
	@DeleteMapping("/{id}")
	public void delete(@PathVariable Long id) {
		Optional<Noticia> noticia = noticiaRepository.findById(id);
		if (noticia.isEmpty()) {
			throw new ResponseStatusException(HttpStatus.NOT_FOUND);
		}
		noticiaRepository.deleteById(id);
	}

}

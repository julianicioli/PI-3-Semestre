package com.aquasense.noticias.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.aquasense.noticias.model.Usuario;
import com.aquasense.noticias.repository.NoticiaRepository;
import com.aquasense.noticias.repository.UsuarioRepository;

import jakarta.validation.Valid;

@RestController
@RequestMapping("/usuarios")
@CrossOrigin(origins = "*", allowedHeaders = "*")
public class UsuarioController {
	
	// Criar a injeção de dependencia:
	@Autowired
	private UsuarioRepository usuarioRepository;
	
	@Autowired
	private NoticiaRepository noticiaRepository;
	
	// Listar todos Usuários
	@GetMapping
	public ResponseEntity<List<Usuario>> getAll() {
		return ResponseEntity.ok(usuarioRepository.findAll());
	}
	
	// Buscar pelo Id
	@GetMapping("/{id}")
	public ResponseEntity<Usuario> getById(@PathVariable Long id) {
		return usuarioRepository.findById(id).map(resposta -> ResponseEntity.ok(resposta))
				.orElse(ResponseEntity.notFound().build());
	}

	// Buscar pelo nome
	@GetMapping("/usuario/{usuario}")
	public ResponseEntity<List<Usuario>> getAllByNome(@PathVariable String nome) {
		return ResponseEntity.ok(usuarioRepository.findAllByNomeContainingIgnoreCase(nome));
	}

	// Criar novo usuário
    @PostMapping
    public ResponseEntity<Usuario> post(@Valid @RequestBody Usuario usuario) {
        usuario.setId(null); // garante que seja uma inserção e não atualização
        Usuario novoUsuario = usuarioRepository.save(usuario);
        return ResponseEntity.status(HttpStatus.CREATED).body(novoUsuario);
    }

    // Atualizar usuário existente
    @PutMapping
    public ResponseEntity<Usuario> put(@Valid @RequestBody Usuario usuario) {
        if (usuarioRepository.existsById(usuario.getId())) {
            Usuario usuarioAtualizado = usuarioRepository.save(usuario);
            return ResponseEntity.ok(usuarioAtualizado);
        }
        return ResponseEntity.notFound().build();
    }
	

}

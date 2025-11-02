package com.aquasense.noticias.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;

import com.aquasense.noticias.model.Categoria;

public interface CategoriaRepository extends JpaRepository<Categoria, Long> {
	List<Categoria> findAllByCategoriaContainingIgnoreCase(String categoria);

}



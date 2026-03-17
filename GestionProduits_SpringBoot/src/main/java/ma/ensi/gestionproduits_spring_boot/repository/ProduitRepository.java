package ma.ensi.gestionproduits_spring_boot.repository;

import ma.ensi.gestionproduits_spring_boot.model.Produit;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ProduitRepository extends JpaRepository<Produit,Integer> {

}

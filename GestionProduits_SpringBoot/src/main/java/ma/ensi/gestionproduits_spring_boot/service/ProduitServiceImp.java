package ma.ensi.gestionproduits_spring_boot.service;

import ma.ensi.gestionproduits_spring_boot.model.Produit;
import ma.ensi.gestionproduits_spring_boot.repository.ProduitRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ProduitServiceImp implements IService{

    @Autowired
    ProduitRepository repo;
    @Override
    public List<Produit> findAllProducts() {
        return repo.findAll();
    }

    @Override
    public void AddProduct(Produit p) {
        repo.save(p);
    }

    @Override
    public void DeleteProduct(Integer id) {
        repo.deleteById(id);
    }

    @Override
    public Produit findByIdProduct(Integer id) {
        return repo.findById(id).orElse(null);
    }

    @Override
    public void updateProduct(Produit p) {
        repo.save(p);
    }
}

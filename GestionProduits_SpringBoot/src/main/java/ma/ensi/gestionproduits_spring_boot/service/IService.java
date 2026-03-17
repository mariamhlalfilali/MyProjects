package ma.ensi.gestionproduits_spring_boot.service;

import ma.ensi.gestionproduits_spring_boot.model.Produit;

import java.util.List;

public interface IService {
    public List<Produit> findAllProducts();
    public void AddProduct(Produit p);
    public void DeleteProduct(Integer id);
    public Produit findByIdProduct(Integer id);
    public void updateProduct(Produit p);
}

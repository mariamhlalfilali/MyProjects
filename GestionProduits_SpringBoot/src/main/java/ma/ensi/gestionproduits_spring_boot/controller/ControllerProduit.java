package ma.ensi.gestionproduits_spring_boot.controller;


import ma.ensi.gestionproduits_spring_boot.model.Produit;
import ma.ensi.gestionproduits_spring_boot.service.IService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;

@Controller
public class ControllerProduit {
    @Autowired
    IService service;
    @GetMapping("/")
    public String home(Model model) {
        model.addAttribute("produits",service.findAllProducts());
        return "listeProduct";
    }
    @GetMapping("/add")
    public String showAddForm(Model model) {
        model.addAttribute("produit", new Produit());
        return "addProduct";
    }
    @PostMapping("/save")
    public String saveEtudiant(@ModelAttribute Produit p) {
        service.AddProduct(p);
        return "redirect:/";
    }

    @PostMapping("/update")
    public String updateEtudiant(@ModelAttribute Produit p) {
        service.updateProduct(p);
        return "redirect:/";
    }
    @GetMapping("/edit/{id}")
    public String showEditForm(@PathVariable("id") Integer id, Model model) {
        Produit p = service.findByIdProduct(id);
        model.addAttribute("produit", p);
        return "editProduct";
    }
    @GetMapping("/delete/{id}")
    public String deleteEtudiant(@PathVariable("id") Integer id) {
        service.DeleteProduct(id);
        return "redirect:/";
    }
}

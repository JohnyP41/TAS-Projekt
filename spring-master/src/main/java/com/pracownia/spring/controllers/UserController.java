package com.pracownia.spring.controllers;

import com.pracownia.spring.entities.User;
import com.pracownia.spring.services.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.view.RedirectView;

import javax.validation.Valid;
import javax.validation.constraints.NotNull;
import java.util.Optional;
import java.util.UUID;

/**
 *  User controller.
 */
@RestController
@RequestMapping("/api")
public class UserController {

    @Autowired
    private UserService userService;


    /**
     * List all products.
     *
     */
    @RequestMapping(value = "/users", method = RequestMethod.GET, produces = MediaType.APPLICATION_JSON_VALUE)
    public Iterable<User> list(Model model) {
        return userService.listAllUsers();
    }

    @RequestMapping(value = "/users/{page}", method = RequestMethod.GET, produces = MediaType.APPLICATION_JSON_VALUE)
    public Iterable<User> list(@PathVariable("page") Integer pageNr,@RequestParam("size") Optional<Integer> howManyOnPage) {
        return userService.listAllUsersPaging(pageNr, howManyOnPage.orElse(2));
    }


    /**
     * View a specific product by its id.
     *
     */
    @RequestMapping(value = "/user/{id}", method = RequestMethod.GET, produces = MediaType.APPLICATION_JSON_VALUE)
    public User getByPublicId(@PathVariable("id") Integer publicId) {
        return userService.getUserById(publicId);
    }

    /**
     * View a specific product by its id.
     *
     */
    @RequestMapping(value = "/user", method = RequestMethod.GET, produces = MediaType.APPLICATION_JSON_VALUE)
    public User getByParamPublicId(@RequestParam("id") Integer publicId) {
        return userService.getUserById(publicId);
    }

    /**
     * Save product to database.
     *
     */
    @RequestMapping(value = "/user", method = RequestMethod.POST)
    public ResponseEntity<User> create(@RequestBody @Valid @NotNull User user) {
        user.setUserId(UUID.randomUUID().toString());
        userService.saveUser(user);
        return ResponseEntity.ok().body(user);
    }


    /**
     * Edit product in database.
     *
     */
    @RequestMapping(value = "/user", method = RequestMethod.PUT)
    public ResponseEntity<Void> edit(@RequestBody @Valid @NotNull User user) {
        if(!userService.checkIfExist(user.getId()))
            return new ResponseEntity<>(HttpStatus.NO_CONTENT);
        else {
            userService.saveUser(user);
            return new ResponseEntity<>(HttpStatus.CREATED);
        }
    }

    /**
     * Delete product by its id.
     *
     */
    @RequestMapping(value = "/user/{id}", method = RequestMethod.DELETE)
    public RedirectView delete(@PathVariable Integer id) {
        userService.deleteUser(id);
        return new RedirectView("/api/users", true);
    }

}

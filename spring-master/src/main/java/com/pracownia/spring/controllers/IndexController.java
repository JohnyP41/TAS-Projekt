package com.pracownia.spring.controllers;

import com.pracownia.spring.entities.User;
import com.pracownia.spring.services.UserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import java.util.UUID;

/**
 * Homepage controller.
 */
@RestController
@RequestMapping("/")
public class IndexController {


    @Autowired
    private UserService userService;

    @RequestMapping(value = "", method = RequestMethod.GET)
    String index() {
        return "index";
    }


    @RequestMapping(value = "generateModel", method = RequestMethod.POST, produces = MediaType.TEXT_PLAIN_VALUE)
    public String generateModel() {

        User u1 = new User(UUID.randomUUID().toString(),"John31","dfsd3534fsd","Jan","Przybylski",1,"admin");
        userService.saveUser(u1);

        User u2 = new User(UUID.randomUUID().toString(),"Krzyszto13","d1dadf1231sd","Krzysztof","Czerwiński",1,"admin");
        userService.saveUser(u2);

        User u3 = new User(UUID.randomUUID().toString(),"Dariusz42","d1dad130239","Dariusz","Wdowczyk",1,"admin");
        userService.saveUser(u3);

        return "Model wygenerowany";
    }

}

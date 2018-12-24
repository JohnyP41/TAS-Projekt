package com.pracownia.spring.services;
import com.pracownia.spring.entities.User;

import java.util.Optional;

public interface UserService {

    Iterable<User> listAllUsers();

    User getUserById(Integer id);

    User saveUser(User user);

    void deleteUser(Integer id);

    void voteOnUser(Integer id);

    Boolean checkIfExist(Integer id);

    public Iterable<User> listAllUsersPaging(Integer pageNr, Integer howManyOnPage);

}

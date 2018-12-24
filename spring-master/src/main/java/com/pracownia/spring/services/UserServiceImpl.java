package com.pracownia.spring.services;

import com.pracownia.spring.entities.User;
import com.pracownia.spring.repositories.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.PageRequest;
import org.springframework.stereotype.Service;

/**
 * User service implement.
 */
@Service
public class UserServiceImpl implements UserService {

    @Autowired
    private UserRepository userRepository;

    @Override
    public Iterable<User> listAllUsersPaging(Integer pageNr, Integer howManyOnPage) {
        return userRepository.findAll(new PageRequest(pageNr,howManyOnPage));
    }

    @Override
    public Iterable<User> listAllUsers() {
        return userRepository.findAll();
    }

    @Override
    public User getUserById(Integer id) {
        return userRepository.findOne(id);
    }

    @Override
    public User saveUser(User user) {
        return userRepository.save(user);
    }

    @Override
    public void deleteUser(Integer id) {
        userRepository.delete(id);
    }

    @Override
    public void voteOnUser(Integer id) {userRepository.count();}

    @Override
    public Boolean checkIfExist(Integer id) {
        if (userRepository.checkIfExist(id) > 0)
            return true;
        else
            return false;
    }


}

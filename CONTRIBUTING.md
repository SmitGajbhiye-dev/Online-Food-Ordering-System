# Contributing to Online Food Ordering System

First off, thank you for considering contributing to the Online Food Ordering System! It's people like you that make this such a great resource for learning web development and database design.

## Code of Conduct

This project and everyone participating in it is governed by our [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the issue list as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

* **Use a clear and descriptive title**
* **Describe the exact steps which reproduce the problem**
* **Provide specific examples to demonstrate the steps**
* **Describe the behavior you observed after following the steps**
* **Explain which behavior you expected to see instead and why**
* **Include screenshots and animated GIFs if possible**
* **Include your environment details** (XAMPP version, PHP version, MySQL version, OS)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

* **Use a clear and descriptive title**
* **Provide a step-by-step description of the suggested enhancement**
* **Provide specific examples to demonstrate the steps**
* **Describe the current behavior and the expected behavior**
* **Explain why this enhancement would be useful**

### Pull Requests

* Fill in the required template
* Follow the PHP styleguides
* Include appropriate test cases for the changes
* Document code changes appropriately
* Ensure your PR passes all tests

## Styleguides

### PHP Code Style

* Use meaningful variable names
* Follow PSR-12 coding standards
* Add comments for complex logic
* Use proper error handling
* Avoid using deprecated functions

```php
// Good
$user_email = $_POST['email'];
$password_hash = md5($password);

// Avoid
$ue = $_POST['e'];
$ph = md5($p);
```

### SQL Code Style

* Use UPPERCASE for SQL keywords
* Use descriptive table and column names
* Always use parameterized queries (prepared statements)
* Include comments for complex queries

```sql
-- Good
SELECT user_id, user_name, user_email 
FROM users 
WHERE user_id = ? AND created_at > ?;

-- Avoid
select * from users where id = $_POST['id'];
```

### HTML/CSS Style

* Use semantic HTML elements
* Follow BEM naming convention for CSS classes
* Use responsive design practices
* Ensure accessibility compliance

```html
<!-- Good -->
<div class="cart__item">
  <h3 class="cart__item-title">Item Name</h3>
  <p class="cart__item-price">Price</p>
</div>

<!-- Avoid -->
<div id="item1">
  <h3>Item Name</h3>
  <p>Price</p>
</div>
```

### Commit Messages

* Use the present tense ("Add feature" not "Added feature")
* Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
* Limit the first line to 72 characters or less
* Reference issues and pull requests liberally after the first line

```
Add user authentication system

- Implement registration page with email validation
- Create login functionality with session management
- Add password hashing using MD5
- Include logout feature

Fixes #123
```

## Development Setup

1. **Fork and Clone**
```bash
git clone https://github.com/YOUR_USERNAME/Online-Food-Ordering-System.git
cd Online-Food-Ordering-System
```

2. **Create Feature Branch**
```bash
git checkout -b feature/your-feature-name
```

3. **Setup XAMPP**
   - Install XAMPP if not already installed
   - Copy project to `C:\xampp\htdocs\`
   - Start Apache and MySQL

4. **Create Database**
   - Open phpMyAdmin
   - Import `database.sql`
   - Verify all tables are created

5. **Make Changes**
   - Edit files as needed
   - Test changes locally
   - Run test cases from TESTING_GUIDE.md

6. **Commit and Push**
```bash
git add .
git commit -m "Describe your changes"
git push origin feature/your-feature-name
```

7. **Create Pull Request**
   - Go to GitHub repository
   - Click "New Pull Request"
   - Fill in the PR template
   - Submit for review

## Testing

Before submitting a pull request, please ensure:

* No syntax errors in PHP files
* All existing tests still pass
* New functionality is covered by tests
* Code works on Windows, Mac, and Linux

Run the following checks:

```bash
# Check PHP syntax
php -l filename.php

# Run all test cases from TESTING_GUIDE.md
```

## File Structure

When adding new features, maintain the following structure:

```
food-ordering/
├── USER_PAGES/        # User-facing pages
├── ADMIN_PAGES/       # Admin-facing pages
├── CONFIGURATION/     # Database and settings
├── style.css          # Styling
└── database.sql       # Database schema
```

**Do not add:**
- Test files outside of TESTING_GUIDE.md
- IDE-specific files (covered by .gitignore)
- Large media files or dependencies

## Documentation

When adding new features, update:

1. **README.md** - Add feature to Features section
2. **SDLC_DOCUMENTATION.md** - Update database schema if needed
3. **TESTING_GUIDE.md** - Add test cases for new feature
4. **VIVA_QUESTIONS.md** - Add Q&As if relevant
5. **Code comments** - Document complex logic

## Additional Notes

### Issue and Pull Request Labels

* `bug` - Something isn't working
* `enhancement` - New feature or request
* `documentation` - Improvements or additions to documentation
* `good first issue` - Good for newcomers
* `help wanted` - Extra attention is needed
* `question` - Further information is requested
* `wontfix` - This will not be worked on

### Getting Help

* Check existing issues and pull requests
* Refer to [EXECUTION_GUIDE.md](EXECUTION_GUIDE.md) for setup issues
* Review [VIVA_QUESTIONS.md](VIVA_QUESTIONS.md) for concept explanations
* Ask questions in new issues with `question` label

## Recognition

Contributors will be recognized in:
- README.md Contributors section
- GitHub contributors page
- CHANGELOG.md for significant changes

## Checklist for Pull Requests

Before submitting, ensure:

- [ ] Code follows the styleguides
- [ ] Comments are added for complex logic
- [ ] Documentation has been updated
- [ ] Tests have been added/updated
- [ ] All tests pass locally
- [ ] No unnecessary files have been added
- [ ] Commit messages are clear and descriptive

## Questions?

Feel free to contact the maintainer or open an issue with the `question` label.

---

**Thank you for contributing! Your efforts help make this resource better for all students.** 🙏

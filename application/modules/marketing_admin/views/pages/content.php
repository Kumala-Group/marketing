<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form">Project Info</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <div class="card-text">
                            <p>This is the most basic and default form having form sections. To add form section use <code>.form-section</code> class with any heading tags. This form has the buttons on the bottom left corner which is the default position.</p>
                        </div>
                        <form class="form">
                            <div class="form-body">
                                <h4 class="form-section"><i class="icon-head"></i> Personal Info</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">First Name</label>
                                            <input type="text" id="projectinput1" class="form-control" placeholder="First Name" name="fname">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2">Last Name</label>
                                            <input type="text" id="projectinput2" class="form-control" placeholder="Last Name" name="lname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput3">E-mail</label>
                                            <input type="text" id="projectinput3" class="form-control" placeholder="E-mail" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput4">Contact Number</label>
                                            <input type="text" id="projectinput4" class="form-control" placeholder="Phone" name="phone">
                                        </div>
                                    </div>
                                </div>

                                <h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>

                                <div class="form-group">
                                    <label for="companyName">Company</label>
                                    <input type="text" id="companyName" class="form-control" placeholder="Company Name" name="company">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput5">Interested in</label>
                                            <select id="projectinput5" name="interested" class="form-control">
                                                <option value="none" selected="" disabled="">Interested in</option>
                                                <option value="design">design</option>
                                                <option value="development">development</option>
                                                <option value="illustration">illustration</option>
                                                <option value="branding">branding</option>
                                                <option value="video">video</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput6">Budget</label>
                                            <select id="projectinput6" name="budget" class="form-control">
                                                <option value="0" selected="" disabled="">Budget</option>
                                                <option value="less than 5000$">less than 5000$</option>
                                                <option value="5000$ - 10000$">5000$ - 10000$</option>
                                                <option value="10000$ - 20000$">10000$ - 20000$</option>
                                                <option value="more than 20000$">more than 20000$</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Select File</label>
                                    <label id="projectinput7" class="file center-block">
                                        <input type="file" id="file">
                                        <span class="file-custom"></span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="projectinput8">About Project</label>
                                    <textarea id="projectinput8" rows="5" class="form-control" name="comment" placeholder="About Project"></textarea>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-colored-form-control">User Profile</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">

                        <div class="card-text">
                            <p>You can always change the border color of the form controls using <code>border-*</code> class. In this example we have user <code>border-primary</code> class for form controls. Form action buttons are on the bottom right position.</p>
                        </div>

                        <form class="form">
                            <div class="form-body">
                                <h4 class="form-section"><i class="icon-eye6"></i> About User</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userinput1">Fist Name</label>
                                            <input type="text" id="userinput1" class="form-control border-primary" placeholder="Name" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userinput2">Last Name</label>
                                            <input type="text" id="userinput2" class="form-control border-primary" placeholder="Company" name="company">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userinput3">Username</label>
                                            <input type="text" id="userinput3" class="form-control border-primary" placeholder="Username" name="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userinput4">Nick Name</label>
                                            <input type="text" id="userinput4" class="form-control border-primary" placeholder="Nick Name" name="nickname">
                                        </div>
                                    </div>
                                </div>

                                <h4 class="form-section"><i class="icon-mail6"></i> Contact Info & Bio</h4>

                                <div class="form-group">
                                    <label for="userinput5">Email</label>
                                    <input class="form-control border-primary" type="email" placeholder="email" id="userinput5">
                                </div>

                                <div class="form-group">
                                    <label for="userinput6">Website</label>
                                    <input class="form-control border-primary" type="url" placeholder="http://" id="userinput6">
                                </div>

                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input class="form-control border-primary" id="userinput7" type="tel" placeholder="Contact Number">
                                </div>

                                <div class="form-group">
                                    <label for="userinput8">Bio</label>
                                    <textarea id="userinput8" rows="5" class="form-control border-primary" name="bio" placeholder="Bio"></textarea>
                                </div>

                            </div>

                            <div class="form-actions right">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row match-height">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-tooltip">Issue Tracking</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">

                        <div class="card-text">
                            <p>This form shows tooltips on hover to provide useful information while user is filling the form. Use data attributes like toggle <code>data-toggle</code>, trigger <code>data-trigger</code>, placement <code>data-placement</code>, title <code>data-title</code> to show tooltips on form controls.</p>
                        </div>

                        <form class="form">
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="issueinput1">Issue Title</label>
                                    <input type="text" id="issueinput1" class="form-control" placeholder="issue title" name="issuetitle" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issue Title">
                                </div>

                                <div class="form-group">
                                    <label for="issueinput2">Opened By</label>
                                    <input type="text" id="issueinput2" class="form-control" placeholder="opened by" name="openedby" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Opened By">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="issueinput3">Date Opened</label>
                                            <input type="date" id="issueinput3" class="form-control" name="dateopened" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Opened">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="issueinput4">Date Fixed</label>
                                            <input type="date" id="issueinput4" class="form-control" name="datefixed" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="issueinput5">Priority</label>
                                    <select id="issueinput5" name="priority" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="issueinput6">Status</label>
                                    <select id="issueinput6" name="status" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Status">
                                        <option value="not started">Not Started</option>
                                        <option value="started">Started</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="issueinput8">Comments</label>
                                    <textarea id="issueinput8" rows="5" class="form-control" name="comments" placeholder="comments" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Comments"></textarea>
                                </div>

                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-icons">Timesheet</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">

                        <div class="card-text">
                            <p>This form shows the use of icons with form controls. Define the position of the icon using <code>has-icon-left</code> or <code>has-icon-right</code> class. Use <code>icon-*</code> class to define the icon for the form control. See Icons sections for the list of icons you can use. </p>
                        </div>

                        <form class="form">
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="timesheetinput1">Employee Name</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="timesheetinput1" class="form-control" placeholder="employee name" name="employeename">
                                        <div class="form-control-position">
                                            <i class="icon-head"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="timesheetinput2">Project Name</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="text" id="timesheetinput2" class="form-control" placeholder="project name" name="projectname">
                                        <div class="form-control-position">
                                            <i class="icon-briefcase4"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="timesheetinput3">Date</label>
                                    <div class="position-relative has-icon-left">
                                        <input type="date" id="timesheetinput3" class="form-control" name="date">
                                        <div class="form-control-position">
                                            <i class="icon-calendar5"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Rate Per Hour</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" class="form-control" placeholder="Rate Per Hour" aria-label="Amount (to the nearest dollar)" name="rateperhour">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="timesheetinput5">Start Time</label>
                                            <div class="position-relative has-icon-left">
                                                <input type="time" id="timesheetinput5" class="form-control" name="starttime">
                                                <div class="form-control-position">
                                                    <i class="icon-clock5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="timesheetinput6">End Time</label>
                                            <div class="position-relative has-icon-left">
                                                <input type="time" id="timesheetinput6" class="form-control" name="endtime">
                                                <div class="form-control-position">
                                                    <i class="icon-clock5"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="timesheetinput7">Notes</label>
                                    <div class="position-relative has-icon-left">
                                        <textarea id="timesheetinput7" rows="5" class="form-control" name="notes" placeholder="notes"></textarea>
                                        <div class="form-control-position">
                                            <i class="icon-file2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions right">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row match-height">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-round-controls">Complaint Form</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">

                        <div class="card-text">
                            <p>This is a variation to the default form control styling. In this example all the form controls has round styling. To apply round style add class <code>round</code> to any form control.</p>
                        </div>

                        <form class="form">
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="complaintinput1">Company Name</label>
                                    <input type="text" id="complaintinput1" class="form-control round" placeholder="company name" name="companyname">
                                </div>

                                <div class="form-group">
                                    <label for="complaintinput2">Employee Name</label>
                                    <input type="text" id="complaintinput2" class="form-control round" placeholder="employee name" name="employeename">
                                </div>

                                <div class="form-group">
                                    <label for="complaintinput3">Date of Complaint</label>
                                    <input type="date" id="complaintinput3" class="form-control round" name="complaintdate">
                                </div>


                                <div class="form-group">
                                    <label for="complaintinput4">Supervisor's Name</label>
                                    <input type="text" id="complaintinput4" class="form-control round" placeholder="supervisor name" name="supervisorname">
                                </div>


                                <div class="form-group">
                                    <label for="complaintinput5">Complaint Details</label>
                                    <textarea id="complaintinput5" rows="5" class="form-control round" name="complaintdetails" placeholder="details"></textarea>
                                </div>


                                <div class="form-group">
                                    <label for="complaintinput6">Signature</label>
                                    <input type="text" id="complaintinput6" class="form-control round" placeholder="signature" name="signature">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-square-controls">Donation</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">

                        <div class="card-text">
                            <p>This is another variation to the default form control styling. In this example all the form controls has square styling. To apply square style add class <code>square</code> to any form control.</p>
                        </div>

                        <form class="form">
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="donationinput1">Full Name</label>
                                    <input type="text" id="donationinput1" class="form-control square" placeholder="name" name="fullname">
                                </div>

                                <div class="form-group">
                                    <label for="donationinput2">Email</label>
                                    <input type="email" id="donationinput2" class="form-control square" placeholder="email" name="email">
                                </div>

                                <div class="form-group">
                                    <label for="donationinput3">Contact Number</label>
                                    <input type="tel" id="donationinput3" class="form-control square" name="contact">
                                </div>

                                <div class="form-group">
                                    <label for="donationinput4">Dontaion Type</label>
                                    <input type="text" id="donationinput4" class="form-control square" placeholder="type of donation" name="donationtype">
                                </div>

                                <div class="form-group">
                                    <label>Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" class="form-control square" placeholder="amount" aria-label="Amount (to the nearest dollar)" name="amount">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="donationinput7">Comments</label>
                                    <textarea id="donationinput7" rows="5" class="form-control square" name="comments" placeholder="comments"></textarea>
                                </div>

                            </div>

                            <div class="form-actions right">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form-center">Event Registration</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">

                        <div class="card-text">
                            <p>This example shows a way to center your form in the card. Here we have used <code>col-md-6 offset-md-3</code> classes to center the form in a full width card. User can always change those classes according to width and offset requirements. This example also uses form action buttons in the center bottom position of the card.</p>
                        </div>

                        <form class="form">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="eventInput1">Full Name</label>
                                            <input type="text" id="eventInput1" class="form-control" placeholder="name" name="fullname">
                                        </div>

                                        <div class="form-group">
                                            <label for="eventInput2">Title</label>
                                            <input type="text" id="eventInput2" class="form-control" placeholder="title" name="title">
                                        </div>

                                        <div class="form-group">
                                            <label for="eventInput3">Company</label>
                                            <input type="text" id="eventInput3" class="form-control" placeholder="company" name="company">
                                        </div>

                                        <div class="form-group">
                                            <label for="eventInput4">Email</label>
                                            <input type="email" id="eventInput4" class="form-control" placeholder="email" name="email">
                                        </div>

                                        <div class="form-group">
                                            <label for="eventInput5">Contact Number</label>
                                            <input type="tel" id="eventInput5" class="form-control" name="contact" placeholder="contact number">
                                        </div>

                                        <div class="form-group">
                                            <label>Existing Customer</label>
                                            <div class="input-group">
                                                <label class="display-inline-block custom-control custom-radio ml-1">
                                                    <input type="radio" name="customer1" class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description ml-0">Yes</span>
                                                </label>
                                                <label class="display-inline-block custom-control custom-radio">
                                                    <input type="radio" name="customer1" checked class="custom-control-input">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description ml-0">No</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-actions center">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-card-center">Event Registration</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        <div class="card-text">
                            <p>This example shows a ways to center your card with form. Here we have used <code>col-md-6 offset-md-3</code> classes to center the card as its not full width. User can always change those classes according to width and offset requirements. This example also uses form action buttons in the center bottom position of the card.</p>
                        </div>
                        <form class="form">
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="eventRegInput1">Full Name</label>
                                    <input type="text" id="eventRegInput1" class="form-control" placeholder="name" name="fullname">
                                </div>

                                <div class="form-group">
                                    <label for="eventRegInput2">Title</label>
                                    <input type="text" id="eventRegInput2" class="form-control" placeholder="title" name="title">
                                </div>

                                <div class="form-group">
                                    <label for="eventRegInput3">Company</label>
                                    <input type="text" id="eventRegInput3" class="form-control" placeholder="company" name="company">
                                </div>

                                <div class="form-group">
                                    <label for="eventRegInput4">Email</label>
                                    <input type="email" id="eventRegInput4" class="form-control" placeholder="email" name="email">
                                </div>

                                <div class="form-group">
                                    <label for="eventRegInput5">Contact Number</label>
                                    <input type="tel" id="eventRegInput5" class="form-control" name="contact" placeholder="contact number">
                                </div>

                                <div class="form-group">
                                    <label>Existing Customer</label>
                                    <div class="input-group">
                                        <label class="display-inline-block custom-control custom-radio ml-1">
                                            <input type="radio" name="customer" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description ml-0">Yes</span>
                                        </label>
                                        <label class="display-inline-block custom-control custom-radio">
                                            <input type="radio" name="customer" checked class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description ml-0">No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions center">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="icon-cross2"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-check2"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>